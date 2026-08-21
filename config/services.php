<?php

declare(strict_types=1);

use Fight\Common\Application\Service\Container;
use Symfony\Component\Finder\Finder;

/**
 * Loads services
 */
function load_services(string $filePath, Container $container): void
{
    include $filePath;
}

$container = new Container();

// PARAMETERS
$finder = new Finder();
$finder->files()->name('*.php')->in(sprintf('%s/parameters', __DIR__));
foreach ($finder as $file) {
    $filePath = $file->getRealPath();
    load_services($filePath, $container);
}

// COMMON
$finder = new Finder();
$finder->files()->name('*.php')->in(sprintf('%s/common', __DIR__));
foreach ($finder as $file) {
    $filePath = $file->getRealPath();
    load_services($filePath, $container);
}

// APPLICATION
$finder = new Finder();
$finder->files()->name('*.php')->in(sprintf('%s/application', __DIR__));
foreach ($finder as $file) {
    $filePath = $file->getRealPath();
    load_services($filePath, $container);
}

return $container;
