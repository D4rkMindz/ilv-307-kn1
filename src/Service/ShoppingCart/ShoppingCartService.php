<?php

namespace App\Service\ShoppingCart;

use App\Util\CsvReader;
use App\Util\ValidationContext;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class ShoppingCartService
 */
class ShoppingCartService
{
    /**
     * @var Session $session with the session (DI)
     */
    private $session;

    /**
     * ShoppingCartService constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Validate delivered data.
     *
     * @param array $data
     * @return ValidationContext $validationContext
     */
    public function validate(array $data): ValidationContext
    {
        $validationContext = new ValidationContext('Manipulierte Eingabe');
        if (!array_key_exists('id', $data) || !array_key_exists('count', $data)) {
            $msg = 'Missing keys delivered.  @' . date('Y-m-d H:i:s');
            $validationContext->setError('key', $msg);
            return $validationContext;
        }

        if (empty($data['id']) || empty($data['count'])) {
            $msg = 'Empty values delivered. @' . date('Y-m-d H:i:s');
            $validationContext->setError('empty', $msg);
        }

        return $validationContext;
    }

    /**
     * Validate delivered DELETE data.
     *
     * @param array $data
     * @return ValidationContext $validationContext
     */
    public function validateDelete(array $data): ValidationContext
    {
        $validationContext = new ValidationContext('Manipulierte Eingabe');

        if (!array_key_exists('id', $data)) {
            $msg = 'Missing keys delivered.  @' . date('Y-m-d H:i:s');
            $validationContext->setError('key', $msg);
            return $validationContext;
        }

        return $validationContext;
    }

    /**
     * Add to shopping cart.
     *
     * @param array $data
     */
    public function add(array $data)
    {
        $cart = $this->getCart();
        $cart[] = $data;
        $this->save($cart);
    }

    /**
     * Update item.
     *
     * @param string $id
     * @param string|int $value
     */
    public function update(string $id, $value)
    {
        $cart = $this->getCart();
        foreach ($cart as $key => $item) {
            if ($item['id'] === $id) {
                $cart[$key]['count'] = $value;
            }
        }
        $this->save($cart);
    }

    /**
     * Delete item from list.
     *
     * @param string $id
     */
    public function delete(string $id)
    {
        $cart = $this->getCart();
        foreach ($cart as $key => $item) {
            if ($item['id'] === $id) {
                unset($cart[$key]);
            }
        }
        $this->save($cart);
    }

    /**
     * Clear cart.
     */
    public function clear()
    {
        $this->session->set('cart', null);
        $this->session->set('success', true);
    }

    /**
     * Save cart.
     *
     * @param array $cart
     */
    private function save(array $cart)
    {
        $this->session->set('cart', $cart);
    }

    /**
     * Clean up doubled entries
     */
    public function getCart(bool $withPrices = false)
    {
        $cart = $this->session->get('cart');
        $this->sort($cart);
        $this->clean($cart);
        if ($withPrices) {
            $this->addPrice($cart);
        }
        return $cart;
    }

    /**
     * Get product count.
     *
     * @return int
     */
    public function getCount()
    {
        $cart = $this->session->get('cart');
        $this->sort($cart);
        $this->clean($cart);
        return count($cart);
    }

    /**
     * Sort cart data.
     *
     * @param array $cart
     */
    private function sort(&$cart)
    {
        if (!empty($cart)) {
            usort($cart, function ($a, $b) {
                return $a['id'] <=> $b['id'];
            });
        }
    }

    /**
     * Clean up doubled entries.
     *
     * @param array $sorted
     */
    private function clean(&$sorted)
    {
        $res = [];
        $def = [];
        if (!empty($sorted)){
            foreach ($sorted as $key => $value) {
                $res[$value['id']] += $value['count'];
            }
            foreach ($res as $key => $value) {
                $def[] = ['id' => $key, 'count' => $value];
            }
        }
        $sorted = $def;
    }

    /**
     * Add Price to products.
     *
     * @param $cleaned
     */
    private function addPrice(&$cleaned)
    {
        $csvReader = new CsvReader(config()->get('csv_file.dir'));
        $data = $csvReader->readAll();

        foreach ($cleaned as $key => $value) {
            foreach ($data as $item) {
                if ($value['id'] == $item['titel']) {
                    $price = $value['count'] * $item['preis'];
                    $cleaned[$key]['price'] = number_format((float)$price, 2, '.', '');;
                }
            }
        }
    }
}
