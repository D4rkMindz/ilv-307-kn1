<?php


namespace App\Service\ShoppingCart;

/**
 * Class OrderService
 */
class OrderService
{
    /**
     * Send email. For configuration see config.php/env.php
     *
     * @param array $data
     * @throws \Exception
     */
    public function sendEmail(array $data)
    {
        $mail = mailer();
        $config = config()->get('mail');
        $mail->setFrom($config['from']);
        $mail->addAddress($config['to']);
        $mail->Subject = 'Bestellung';
        $message = "\nSie haben einen neuen Kunden: \nVorname: " . $data['firstname'] . " \nNachname: " .
            $data['lastname'] . " \nEmail: " . $data['email'] . " \nAdresse: \n" . $data['street'] . " \n" .
            $data['postcode'] . " " . $data['city'] . "\nBestellung:\n";
        foreach ($data['products'] as $product) {
            $message .= "\n\t" . $product['id'] . ' (' . $product['count'] . ' stk)';
        }
        $mail->Body = $message;
        $mail->AltBody = "";
        $status = $mail->send();
        if (!$status) {
            throw new  \Exception($mail->ErrorInfo);
        }
        // And to the customer...
        // May blocks your server for spam, but not my problem :)
        // If sending emails fail, delete the block below
        $mail->setFrom($config['from']);
        $mail->addAddress($data['email']);
        $mail->Subject = 'Bestellung';
        $message = "\nSie haben einen neuen Kunden: \nVorname: " . $data['firstname'] . " \nNachname: " .
            $data['lastname'] . " \nEmail: " . $data['email'] . " \nAdresse: \n" . $data['street'] . " \n" .
            $data['postcode'] . " " . $data['city'] . "\nBestellung:\n";
        foreach ($data['products'] as $product) {
            $message .= "\n\t" . $product['id'] . ' (' . $product['count'] . ' stk)';
        }
        $mail->Body = $message;
        $mail->AltBody = "";
        $status = $mail->send();
        if (!$status) {
            throw new  \Exception($mail->ErrorInfo);
        }
    }

    /**
     * Sort customer data.
     *
     * @param array $data
     * @return array $res
     */
    public function sortCustomerData(array $data): array
    {
        $res = [];
        $res['a'] = $data['salutation'];
        $res['b'] = $data['firstname'];
        $res['c'] = $data['lastname'];
        $res['d'] = $data['email'];
        $res['e'] = $data['street'] . ' ' . $data['postcode'] . ' ' . $data['city'];
        $res['f'] = $data['total'];
        $res['g'] = $this->formatProducts($data['products']);
        return $res;
    }

    /**
     * Convert product array into string.
     *
     * @param $products
     * @return string
     */
    private function formatProducts(array $products): string
    {
        $result = '';
        foreach ($products as $product) {
            $result .= $product['id'] . '(' . $product['count'] . ') | ';
        }
        return $result;
    }
}
