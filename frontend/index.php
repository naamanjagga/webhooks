<?php

use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Phalcon\Mvc\View\Simple;



define('BASE_PATH', '/');

require_once './vendor/autoload.php';

$loader = new Loader();
$loader->registerNamespaces(
    [
        'Api\Handler' => './handler',
        'Api\Middleware' => './components',
    ]
);

$loader->register();

$loader->registerDirs(
    [
        './controllers/',
    ]
);

$loader->register();

$app = new Micro();

$app['view'] = function () {
    $view = new Simple();
    $view->setViewsDir('./views/');

    return $view;
};

// $app->before(
//     function () use ($app) {
//         $mw  = explode('/', $_SERVER['REQUEST_URI']);
//         if ($mw[1] == "registeruser" || $mw[1] == "acl") {
//             if ($mw[2] == "validate" || $mw[2] == "buildacl") {
//                 return true;
//             }
//         } else {
//             $token = $app->request->get('token');
//             if (isset($token)) {
//                 $checkToken = new Api\Handler\Token();
//                 $name = $checkToken->checkToken($token);
//                 if ($name) {
//                     header('Location: http://localhost:8080/login/index');
//                 } else {
//                     echo 'check yout token';
//                     die;
//                     return false;
//                 }
//             }
//         }
//     }
// );

$products = new MicroCollection();
$products
    ->setHandler(new ProductController())
    ->setPrefix('/product')
    ->get('/search/{keyword}', 'search');

$app->mount($products);
$products = new MicroCollection();
$products
    ->setHandler(new ProductController())
    ->setPrefix('/product')
    ->get('/get', 'index')
    ->get('/get/{keyword}', 'search');

$app->mount($products);

$order = new MicroCollection();
$order
    ->setHandler(new OrderController())
    ->setPrefix('/order')
    ->get('/create/{p_name}/{category}/{price}/{quantity}/{token}', 'create')
    ->get('/update/{id}/{status}', 'update');

$app->mount($order);
$user = new MicroCollection();
$user
    ->setHandler(new RegisteruserController())
    ->setPrefix('/registeruser')
    ->get('/', 'index')
    ->get('/validate', 'validate');

$app->mount($user);
$login = new MicroCollection();
$login
    ->setHandler(new LoginController())
    ->setPrefix('/login')
    ->get('/', 'index')
    ->get('/auth', 'auth');

// $app->mount($login);
// $acl = new MicroCollection();
// $acl
//     ->setHandler(new AclController())
//     ->setPrefix('/acl')
//     ->get('/', 'index')
//     ->get('/buildacl', 'buildacl');

// $app->mount($acl);

$webhooks = new MicroCollection();
$webhooks
    ->setHandler(new WebhooksController())
    ->setPrefix('/webhooks')
    ->get('/', 'index')
    ->post('/storeWebhook', 'storeWebhook');

$app->mount($webhooks);
// $admin = new MicroCollection();
// $admin
//     ->setHandler(new AdminController())
//     ->setPrefix('/admin')
//     ->get('/index', 'index')
//     ->post('/update', 'update')
//     ->post('/change', 'change');

// $app->mount($admin);
$user = new MicroCollection();
$user
    ->setHandler(new UserController())
    ->setPrefix('/user')
    ->get('/index', 'index')
    ->post('/update', 'update');
    // ->post('/change', 'change');

$app->mount($user);


$app->get(
    '/product/get',
    function () use ($app) {
        // app/views/invoices/view.phtml
        echo $app['view']
            ->render(
                '/product/get',
                []
            );
    }
);
$app->get(
    '/registeruser/index',
    function () use ($app) {
        // app/views/invoices/view.phtml
        echo $app['view']
            ->render(
                '/registeruser/index',
                []
            );
    }
);
$app->get(
    '/login/index',
    function () use ($app) {
        // app/views/invoices/view.phtml
        echo $app['view']
            ->render(
                '/login/index',
                []
            );
    }
);
$app->get(
    '/webhooks/index',
    function () use ($app) {
        // app/views/invoices/view.phtml
        echo $app['view']
            ->render(
                '/webhooks/index',
                []
            );
    }
);


// $app->get(
//     '/admin/index',
//     function () use ($app) {
//         // app/views/invoices/view.phtml
//         echo $app['view']
//             ->render(
//                 '/admin/index',
//                 []
//             );
//     }
// );

$app->get(
    '/',
    [
        '/',
        '/'
    ]
);

// $router = new Router();
// $router->add(
//     '/',
//     [
//         'controller' => 'login',
//         'action'     => 'index',
//     ]
// );

$app->handle(
    $_SERVER["REQUEST_URI"]
);
// print_r("FrontEnd"); die;
