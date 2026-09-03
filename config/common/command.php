<?php

declare(strict_types=1);

use Fight\Common\Adapter\Messaging\Command\Sync\CommandPipeline;
use Fight\Common\Adapter\Messaging\Command\Sync\Routing\ServiceAwareCommandRouter;
use Fight\Common\Adapter\Messaging\Command\Sync\RoutingCommandBus;
use Fight\Common\Application\Messaging\Command\CommandBus;
use Fight\Common\Application\Messaging\Command\SynchronousCommandBus;
use Fight\Common\Application\Service\Container;

return [
    'services' => [
        'messaging.command.router' => static fn (Container $container): ServiceAwareCommandRouter => new ServiceAwareCommandRouter($container),
        'messaging.command.routing' => static fn (Container $container): RoutingCommandBus => new RoutingCommandBus($container->get('messaging.command.router')),
        'messaging.command.bus' => static fn (Container $container): CommandPipeline => new CommandPipeline($container->get('messaging.command.routing')),
        CommandBus::class => static fn (Container $container): CommandBus => $container->get('messaging.command.bus'),
        SynchronousCommandBus::class => static fn (Container $container): SynchronousCommandBus => $container->get('messaging.command.bus'),
    ],
    'handlers' => [],
    'filters' => [],
];
