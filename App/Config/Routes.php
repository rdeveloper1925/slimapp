<?php 
namespace App\Config;

use App\Controllers\MscController;
use App\Middleware\ResponseWrapper;
use App\Services\AuthService;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\HelperService;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Routes{

    public static function register($app): void{
        //Miscelleneous routes
        Routes::helperRoutes($app);

        //Protected routes??
        Routes::protectedRoutes($app);

        //Preflight routes handling. prevents the cors errors when using localhost
        //Must be placed before the fallback route.
        Routes::preflightRoutes($app);

        // Default route for everything else
        Routes::fallBackRoute($app);
    }

    public static function helperRoutes($app){
        $app->get('/', [MscController::class, 'sayHello']);
        $app->get('/healthcheck', [MscController::class, 'checkHealth']);
    }

    public static function protectedRoutes(App $app){
        $app->group('/api',function (RouteCollectorProxy $group) use ($app) {
            $group->post('/login', [MscController::class, 'loginSignup']);
        });
    }

    public static function fallBackRoute(App $app){
        return $app->any('/{any:.*}', [MscController::class, 'fallBack']);
    }

    public static function preflightRoutes(App $app){
        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
    }
}