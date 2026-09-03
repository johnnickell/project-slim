<?php

declare(strict_types=1);

use Fight\Common\Adapter\Messaging\Query\QueryPipeline;
use Fight\Common\Adapter\Messaging\Query\Routing\ServiceAwareQueryRouter;
use Fight\Common\Adapter\Messaging\Query\RoutingQueryBus;
use Fight\Common\Application\Messaging\Query\QueryBus;
use Fight\Common\Application\Service\Container;

return [
    'services' => [
        'messaging.query.router' => static fn (Container $container): ServiceAwareQueryRouter => new ServiceAwareQueryRouter($container),
        'messaging.query.routing' => static fn (Container $container): RoutingQueryBus => new RoutingQueryBus($container->get('messaging.query.router')),
        'messaging.query.bus' => static fn (Container $container): QueryPipeline => new QueryPipeline($container->get('messaging.query.routing')),
        QueryBus::class => static fn (Container $container): QueryBus => $container->get('messaging.query.bus'),
    ],
    'handlers' => [],
    'filters' => [],
];
