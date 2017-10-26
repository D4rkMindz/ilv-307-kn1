<?php


namespace App\Controller;


class ContactController extends AppController
{
    public function index()
    {
        $viewData = [
            'title'=> 'Unsere Kontaktdaten',
            'abbr' => 'Kontakt',
            'news' => true,
        ];
        return $this->render('view::Contact/contact.html.php',$viewData);
    }
}
