<?php

declare(strict_types=1);

use Fight\Common\Adapter\Observability\Audit\NullAuditLog;
use Fight\Common\Adapter\Observability\Health\HealthReporter;
use Fight\Common\Adapter\Observability\Metrics\NullMetricsCollector;
use Fight\Common\Application\Observability\AuditLog;
use Fight\Common\Application\Observability\HealthAggregator;
use Fight\Common\Application\Observability\MetricsCollector;
use Fight\Common\Application\Service\Container;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return static function (Container $container): void {
    $container->set(LoggerInterface::class, static function (): Logger { $logger = new Logger('slim'); $logger->pushHandler(new NullHandler()); return $logger; });
    $container->set(HealthAggregator::class, static fn (): HealthAggregator => new HealthReporter());
    $container->set(MetricsCollector::class, static fn (): MetricsCollector => new NullMetricsCollector());
    $container->set(AuditLog::class, static fn (): AuditLog => new NullAuditLog());
};
