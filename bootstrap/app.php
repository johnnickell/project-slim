<?php

declare(strict_types=1);

use App\Service\StarterGreeting;
use Fight\Common\Application\Service\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require sprintf('%s/vendor/autoload.php', dirname(__DIR__));

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
