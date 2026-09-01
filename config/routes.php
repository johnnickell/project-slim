<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Symfony\Component\Finder\Finder;

/** @var App $app */
/** @var ContainerInterface $container */
/**
 * Loads application routes
 */
$loadRoutes = static function (string $filePath, ContainerInterface $container, App $app): void {
    include $filePath;
};

$finder = new Finder();
$finder->files()->name('*.php')->in(sprintf('%s/routes', __DIR__))->sortByName();

foreach ($finder as $file) {
    $filePath = $file->getRealPath();
    $loadRoutes($filePath, $container, $app);
}
