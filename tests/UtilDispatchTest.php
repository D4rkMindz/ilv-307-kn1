<?php

namespace App\Test;

use App\Controller\ErrorController;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class UtilDispatchTest
 */
class UtilDispatchTest extends BaseTest
{
    /**
     * DbBlockedUsersTest dispatch.
     *
     * @covers ::dispatch
     * @covers ::request
     * @covers ::response
     * @covers ::session
     * @covers ::route
     * @covers ::logger
     */
    public function testRegular()
    {
        ob_start();
        $request = request();
        $request->server->set('SERVER_NAME', 'localhost');
        $request->server->set('SERVER_PORT', '80');
        $request->server->set('REQUEST_URI', 'http://localhost/contact_form/');
        $request->server->set('SCRIPT_NAME', '/contact_form/public/index.php');
        //container()->set('request', $request);

        $response = response();
        $routes = new RouteCollection();

        $routes->add('/index', route('GET', '/', 'App\Test\TestController:index'));

        dispatch($request, $response, $routes);

        $obContent = ob_get_contents();
        $expected = json_encode(['response' => 'Hello World!']);
        $this->assertSame($expected, $obContent);
        ob_end_clean();
    }
}
