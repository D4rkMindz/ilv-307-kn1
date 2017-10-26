<?php

namespace App\Service\ShoppingCart;

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
     * Add to shopping cart.
     *
     * @param array $data
     */
    public function add(array $data)
    {
        $cart = $this->session->get('cart');
        $cart[] = $data;
        $this->session->set('cart', $cart);
    }

    /**
     * Clean up doubled entries
     */
    public function getCart()
    {
        $cart = $this->session->get('cart');
        $this->sort($cart);
        $this->clean($cart);
        return $cart;
    }

    /**
     * Sort cart data.
     *
     * @param array $cart
     */
    private function sort(array &$cart)
    {
        usort($cart, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });
    }

    /**
     * Clean up doubled entries.
     *
     * @param array $sorted
     */
    private function clean(array &$sorted)
    {
        $res = [];
        foreach ($sorted as $key => $value) {
            $res[$value['id']] += $value['count'];
        }
        $sorted = $res;
    }
}
