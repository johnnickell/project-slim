<?php

declare(strict_types=1);

use App\Http\IndexAction;
use Fight\Common\Application\Service\Container;

/** @var Container $container */

$container->set(IndexAction::class, function (Container $container) {
    return new IndexAction();
});
