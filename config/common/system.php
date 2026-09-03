<?php

declare(strict_types=1);

use Fight\Common\Adapter\Process\Symfony\SymfonyProcessRunner;
use Fight\Common\Adapter\Routing\Slim\SlimUrlGenerator;
use Fight\Common\Application\Process\ProcessRunner;
use Fight\Common\Application\Routing\UrlGenerator;
use Fight\Common\Application\Scheduler\Scheduler;
use Fight\Common\Application\Service\Container;
use Fight\Common\Application\Filesystem\Filesystem;
use Fight\Common\Domain\Value\DateTime\Timezone;
use Slim\App;
use Slim\Psr7\Uri;

return static function (Container $container): void {
    $container->set(ProcessRunner::class, static fn (Container $c): ProcessRunner => new SymfonyProcessRunner($c->get(\Psr\Log\LoggerInterface::class), delay: 1));
    $container->set(Scheduler::class, static function (Container $c): Scheduler {
        $directory = sprintf('%s/var/scheduler', $c['app.project_dir']);
        $c->get(Filesystem::class)->mkdir($directory);

        return Scheduler::withProcessRunner(new Timezone('UTC'), $directory, $c->get(ProcessRunner::class), $c->get(\Psr\Log\LoggerInterface::class), $c->get(\Fight\Common\Application\Mail\MailService::class));
    });
    $container->set(UrlGenerator::class, static fn (Container $c): UrlGenerator => new SlimUrlGenerator($c->get(App::class)->getRouteCollector(), new Uri('http', 'localhost')));
};
