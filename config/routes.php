<?php

declare(strict_types=1);

use App\Service\StarterGreeting;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

/** @var App $app */
/** @var ContainerInterface $container */
$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) use ($container): ResponseInterface {
    $response->getBody()->write($container->get(StarterGreeting::class)->message());

    return $response;
});
