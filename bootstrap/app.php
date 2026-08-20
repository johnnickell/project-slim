<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require sprintf('%s/vendor/autoload.php', dirname(__DIR__));
$container = require sprintf('%s/config/services.php', dirname(__DIR__));

/**
 * Loads application routes
 */
function load_routes(ContainerInterface $container, App $app): void
{
    include sprintf('%s/config/routes.php', dirname(__DIR__));
}

AppFactory::setContainer($container);
AppFactory::setResponseFactory(new ResponseFactory());
$app = AppFactory::create();
load_routes($container, $app);

return $app;
