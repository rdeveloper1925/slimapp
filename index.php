<?php

use App\Config\Routes;
use App\Middleware\JsonMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;
use DebugBar\StandardDebugBar;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php'; //change this if you ever move this file

//load environment variables. adds them to $_ENV
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

//INITIALIZE DEPENDENCY INJECTION START
$container = new Container();
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__.'/App/Config/configuration.php');
// $containerBuilder->addDefinitions([
//     'stripe' => autowire(StripePaymentGateway::class),
//     'paypal' => autowire(PaypalPaymentGateway::class),
// ]);
// $stripe = $container->get('stripe');
$container = $containerBuilder->build();
//INITIALIZE DEPENDENCY INJECTION END

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->setBasePath($_ENV['BASE_PATH']);

//$app->addErrorMiddleware(true, true, true); //default error management
$app->add(new WhoopsMiddleware([
    'enable' => true,
    'editor' => 'vscode',
    'title'=> 'my title'
]));
$routeParser = $app->getRouteCollector()->getRouteParser();

$app->get('/tt', function(Request $request, Response $response){
    $response->withHeader('Content-Type', 'application/json');
});

//first in, last to be executed as response
$app->add(new JsonMiddleware());

//define routes
Routes::register($app, $routeParser);


$app->run();