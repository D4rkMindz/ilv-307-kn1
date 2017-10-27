<?php

namespace App\Controller;

use App\Service\ShoppingCart\OrderService;
use App\Service\ShoppingCart\OrderValidation;
use App\Service\ShoppingCart\ShoppingCartService;
use App\Util\CsvReader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShoppingCartController
 */
class ShoppingCartController extends AppController
{
    /**
     * Index function.
     *
     * @return Response
     */
    public function index()
    {
        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $data = $shoppingCartService->getCart(true);
        $viewData = [
            'count'=>$count,
            'data' => $data,
            'title' => empty($data) ? 'Dein Warenkorb ist leer' : 'Dein Warenkorb',
            'abbr' => 'Warenkorb',
            'news' => false,
        ];
        return $this->render('view::ShoppingCart/shopping-cart.html.php', $viewData);
    }

    /**
     * Place order.
     *
     * @return JsonResponse
     */
    public function order()
    {
        $data = $this->getJsonRequest($this->request);
        $orderValidation= new OrderValidation();
        $validationContext = $orderValidation->validate($data);
        if ($validationContext->success()){
            $orderService = new OrderService();
            try {
                $orderService->sendEmail($data);
            } catch (\Exception $e){
                logger('email-error')->addAlert($e->getMessage() . ' | ' .  $e->getTraceAsString());
                return $this->json(['status'=> 0]);
            }
            $shoppingCartService = new ShoppingCartService($this->session);
            $shoppingCartService->clear();
            $csvReader = new CsvReader(config()->get('csv_file.dir_save'));
            $data = $orderService->sortCustomerData($data);
            ksort($data);
            $csvReader->write($data);
            return $this->json(['status'=> 1]);
        }
        return $this->json(['status'=> 0]);
    }

    /**
     * Place item into shopping cart.
     *
     * @return JsonResponse
     */
    public function placeItem()
    {
        $data = $this->getJsonRequest($this->request);

        $shoppingCartService = new ShoppingCartService($this->session);

        $validationContext = $shoppingCartService->validate($data);

        if ($validationContext->success()) {
            $shoppingCartService->add($data);
            return $this->json(['status' => 1]);
        }

        logger('validation-errors')->addAlert($validationContext->toJson());
        return $this->json(['status' => 0], 422);
    }

    /**
     * Update item in shopping cart.
     *
     * @return JsonResponse
     */
    public function updateItem()
    {
        $data = $this->getJsonRequest($this->request);

        $shoppingCartService = new ShoppingCartService($this->session);

        $validationContext = $shoppingCartService->validate($data);

        if ($validationContext->success()) {
            $shoppingCartService->update($data['id'], $data['count']);
            return $this->json(['status' => 1]);
        }

        logger('validation-errors')->addAlert($validationContext->toJson());
        return $this->json(['status' => 0], 422);
    }

    /**
     * Delete item from shopping cart.
     *
     * @return JsonResponse
     */
    public function deleteItem()
    {
        $data = $this->getJsonRequest($this->request);
        $shoppingCartService = new ShoppingCartService($this->session);

        $validationContext = $shoppingCartService->validateDelete($data);

        if ($validationContext->success()) {
            $shoppingCartService->delete($data['id']);
            return $this->json(['status' => 1]);
        }

        logger('validation-errors')->addAlert($validationContext->toJson());
        return $this->json(['status' => 0], 422);
    }
}
