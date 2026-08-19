<?php

declare(strict_types=1);

namespace App;

use App\Service\StarterGreeting;
use Fight\Common\Application\Service\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Response;
use Slim\App;

final class Bootstrap
{
    public static function app(): App
    {
        $container = new Container();
        $container->set(StarterGreeting::class, static fn (): StarterGreeting => new StarterGreeting());

        AppFactory::setContainer($container);
        AppFactory::setResponseFactory(new ResponseFactory());
        $app = AppFactory::create();
        $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) use ($container): ResponseInterface {
            $response->getBody()->write($container->get(StarterGreeting::class)->message());

            return $response;
        });

        return $app;
    }
}
