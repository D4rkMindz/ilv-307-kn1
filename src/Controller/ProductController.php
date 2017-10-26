<?php


namespace App\Controller;


class ProductController extends AppController
{
    public function index()
    {
        $viewData = [
            'title' => 'Produkte, frisch ab Hof',
            'abbr' => 'Produkte',
            'news' => true,
        ];
        return $this->render('view::Products/index.html.php', $viewData);
    }

    public function meat()
    {
        $viewData = [
            'title' => 'Fleischliche Produkte in Bio Qualität',
            'abbr' => 'Fleischliche Produkte',
            'news' => true,
        ];
        return $this->render('view::Products/meat.html.php', $viewData);
    }

    public function beef()
    {
        $viewData = [
            'title' => 'Bio Rindfleisch ab Hof',
            'abbr' => 'Rind',
            'news' => true,
        ];
        return $this->render('view::Products/beef.html.php', $viewData);
    }

    public function rabbit()
    {
        $viewData = [
            'title' => 'Kaninchenfleisch aus unserem eigenen Stall',
            'abbr' => 'Kaninchen',
            'news' => false,
        ];
        return $this->render('view::Products/rabbit.html.php', $viewData);
    }

    public function vegetables()
    {
        $viewData = [
            'title' => 'Pflanzliche Produkte ab Hof',
            'abbr' => 'Pflanzliche Produkte',
            'news' => false,
        ];
        return $this->render('view::Products/vegetables.html.php', $viewData);
    }
}
