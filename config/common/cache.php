<?php

declare(strict_types=1);

use Fight\Common\Adapter\Cache\PsrCache;
use Fight\Common\Application\Service\Container;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

return static function (Container $container): void {
    $container->set(CacheItemPoolInterface::class, static fn (): CacheItemPoolInterface => new ArrayAdapter());
    $container->set(CacheInterface::class, static fn (Container $c): CacheInterface => new Psr16Cache($c->get(CacheItemPoolInterface::class)));
    $container->set(PsrCache::class, static fn (Container $c): PsrCache => new PsrCache($c->get(CacheItemPoolInterface::class), $c->get(LoggerInterface::class)));
};
