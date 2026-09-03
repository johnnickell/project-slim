<?php

declare(strict_types=1);

use Fight\Common\Adapter\Messaging\Event\Sync\ServiceAwareEventDispatcher;
use Fight\Common\Application\Messaging\Event\EventDispatcher;
use Fight\Common\Application\Messaging\Event\SynchronousEventDispatcher;
use Fight\Common\Application\Service\Container;

return [
    'services' => [
        'messaging.event.dispatcher' => static fn (Container $container): ServiceAwareEventDispatcher => new ServiceAwareEventDispatcher($container),
        EventDispatcher::class => static fn (Container $container): EventDispatcher => $container->get('messaging.event.dispatcher'),
        SynchronousEventDispatcher::class => static fn (Container $container): SynchronousEventDispatcher => $container->get('messaging.event.dispatcher'),
    ],
    'subscribers' => [],
];
