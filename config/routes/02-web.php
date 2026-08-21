<?php

declare(strict_types=1);

use App\Http\IndexAction;
use Psr\Container\ContainerInterface;
use Slim\App;

/** @var App $app */
/** @var ContainerInterface $container */

// index route
$app->get('/', [IndexAction::class, 'handle']);
