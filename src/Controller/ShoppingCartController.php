<?php

namespace App\Controller;

use App\Service\ShoppingCart\ShoppingCartService;
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
        $data = $shoppingCartService->getCart();
        $viewData = [
            'data' => $data,
            'title'=> 'Dein Warenkorb',
            'abbr' => 'Warenkorb',
            'news' => false,
        ];
        return $this->render('view::ShoppingCart/shopping-cart.html.php', $viewData);
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
}
