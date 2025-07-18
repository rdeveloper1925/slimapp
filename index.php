<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;
use DebugBar\StandardDebugBar;

require __DIR__ . '/vendor/autoload.php'; //change this if you ever move this file

$app = AppFactory::create();

$app->setBasePath('/slim shady');

//$app->addErrorMiddleware(true, true, true); //default
$app->add(new WhoopsMiddleware([
    'enable' => true,
    'editor' => 'vscode',
    'title'=> 'my title'
]));
$routeParser = $app->getRouteCollector()->getRouteParser();
$app->get('/', function (Request $request, Response $response, $args) use ($routeParser) {
    //throw new Exception('testing whoops');
    
    dump([$request, $response]); //php dumper
    $response->getBody()->write("Hello world!");
    
    return $response;
})->setName('hello');

// Default route for everything else
$app->any('/{any:.*}', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Fallback route: " . $request->getUri()->getPath());
    return $response;
});

$app->run();