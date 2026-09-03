<?php

declare(strict_types=1);

use Fight\Common\Adapter\Http\Psr17\JSendResponseFactory;
use Fight\Common\Adapter\Middleware\Psr15\JSendErrorMiddleware;
use Fight\Common\Adapter\Middleware\Psr15\JsonRequestMiddleware;
use Psr\Container\ContainerInterface;
use Slim\App;

/** @var App $app */
/** @var ContainerInterface $container */
// Slim executes middleware last-in, first-out: error -> JSON -> routing -> route.
$app->addRoutingMiddleware();
$app->add(new JsonRequestMiddleware());
$app->add(new JSendErrorMiddleware($container->get(JSendResponseFactory::class)));
