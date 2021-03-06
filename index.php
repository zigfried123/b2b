<?php

require_once './config/mysql.php';

require_once './vendor/autoload.php';

use models\Console;
use models\Mysql;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

Mysql::connect(compact('server', 'user', 'pass', 'database'));

try {
    $q = Mysql::$db->query("SELECT * FROM `migrations` LIMIT 1");
} catch (Exception $e) {
    $q = Mysql::$db->query('CREATE TABLE `migrations` (`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` varchar(255))');
}

if (!empty($argv)) {

    Console::getInstance($argv)->execute();

}

try {
    $get_items_route = new Route(
        '/shop/get-items',
        array('controller' => 'ShopController', 'method' => 'getItems')
    );

    $make_order_route = new Route(
        '/shop/make-order',
        array('controller' => 'ShopController', 'method' => 'makeOrder')
    );

    $pay_order_route = new Route(
        '/shop/pay-order',
        array('controller' => 'ShopController', 'method' => 'payOrder')
    );

    $routes = new RouteCollection();
    $routes->add('get_items_route', $get_items_route);
    $routes->add('make_order_route', $make_order_route);
    $routes->add('pay_order_route', $pay_order_route);


    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());

    $matcher = new UrlMatcher($routes, $context);

    $parameters = $matcher->match($context->getPathInfo());

    $controller = 'controllers\\' . $parameters['controller'];
    $method = $parameters['method'];

    echo (new $controller())->$method();

} catch (ResourceNotFoundException $e) {
    echo $e->getMessage();
}

