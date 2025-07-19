<?php 
namespace App\Config;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\HelperService;
use Slim\App;
use Slim\Interfaces\RouteParserInterface;

class Routes{

    public static function register($app): void{
        $app->get('/', function (Request $request, Response $response, $args) {
            $response->getBody()->write(json_encode("Welcome to the API!")); 
            return $response->withHeader('Content-Type', 'application/json');
            //return $response;
        })->setName('hello');

        $app->get('/healthcheck', function(Request $request, Response $response) use ($app){
            $helperService = $app->getContainer()->get(HelperService::class);
            $response->getBody()->write(json_encode($helperService->healthCheck()));
            return $response->withHeader('Content-Type', 'application/json');
            
        })->setName('healthcheck');

        // Default route for everything else
        Routes::fallBackRoute($app);
    }

    public static function protectedRoutes(App $app){
        $app->group('/api',function () use ($app){
            $app->get('/user/:id', function(){

            });
        });
    }

    public static function fallBackRoute($app){
        return $app->any('/{any:.*}', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Fallback route: " . $request->getUri()->getPath());
            return $response;
        })->setName('fallback');
    }
}