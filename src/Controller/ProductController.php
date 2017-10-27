<?php


namespace App\Controller;


use App\Util\CsvReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductController extends AppController
{
    private $csvFile = '';

    public function __construct(Request $request, Response $response, Session $session)
    {
        $this->csvFile = config()->get('csv_file.dir');
        parent::__construct($request, $response, $session);
    }

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
        $csvReader = new CsvReader($this->csvFile);
        $data = $csvReader->read('rind');

        $viewData = [
            'category'=> 'rind',
            'data' => $data,
            'title' => 'Bio Rindfleisch ab Hof',
            'abbr' => 'Rind',
            'news' => true,
        ];
        return $this->render('view::Products/product.html.php', $viewData);
    }

    public function rabbit()
    {
        $csvReader = new CsvReader($this->csvFile);
        $data = $csvReader->read('kaninchen');

        $viewData = [
            'category'=> 'kaninchen',
            'data' => $data,
            'title' => 'Kaninchenfleisch aus unserem eigenen Stall',
            'abbr' => 'Kaninchen',
            'news' => false,
        ];
        return $this->render('view::Products/product.html.php', $viewData);
    }

    public function vegetables()
    {
        $csvReader = new CsvReader($this->csvFile);
        $data = $csvReader->read('pflanzliches');
        $viewData = [
            'category'=> 'pflanzlich',
            'data'=> $data,
            'title' => 'Pflanzliche Produkte ab Hof',
            'abbr' => 'Pflanzliche Produkte',
            'news' => false,
        ];
        return $this->render('view::Products/product.html.php', $viewData);
    }
}
