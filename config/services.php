<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use App\Http\IndexAction;
use Fight\Common\Adapter\Auth\Security\PhpPasswordHasher;
use Fight\Common\Adapter\Cache\PsrCache;
use Fight\Common\Adapter\EventSourcing\InMemory\InMemoryEventStore;
use Fight\Common\Domain\EventSourcing\EventMapper;
use Fight\Common\Adapter\FileStorage\FlysystemStorage;
use Fight\Common\Adapter\FileTransfer\Null\NullFileTransport;
use Fight\Common\Adapter\HttpClient\Guzzle\GuzzleClient;
use Fight\Common\Adapter\Messaging\Command\Async\MessengerCommandBus;
use Fight\Common\Adapter\Messaging\Event\Async\MessengerEventDispatcher;
use Fight\Common\Adapter\Observability\Audit\NullAuditLog;
use Fight\Common\Adapter\Observability\Health\HealthReporter;
use Fight\Common\Adapter\Observability\Metrics\NullMetricsCollector;
use Fight\Common\Adapter\Routing\Slim\SlimUrlGenerator;
use Fight\Common\Adapter\ServiceContainer\Fight\ContainerCapabilityRegistrar;
use Fight\Common\Adapter\Sms\Null\NullSmsTransport;
use Fight\Common\Adapter\Templating\TwigEngine;
use Fight\Common\Application\Service\Container;
use GuzzleHttp\Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Factory\ResponseFactoryInterface;
use Psr\Http\Factory\ServerRequestFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Validator\Validation;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

$container = new Container();
$rootDir = dirname(__DIR__);

// Core container, parameters, validation, security, and HTTP primitives.
$container->set(Container::class, static fn (): Container => $container);
$container->set(ContainerInterface::class, static fn (): Container => $container);
$container['app.project_dir'] = $rootDir;
$container['app.storage_dir'] = sprintf('%s/var/storage', $rootDir);
$container['app.database_url'] = getenv('DATABASE_URL') ?: 'sqlite:///:memory:';
$container->set('validator', static fn () => Validation::createValidator());
$container->set('security.password_hasher', static fn () => new PhpPasswordHasher(PASSWORD_ARGON2ID));
$container->set(ResponseFactoryInterface::class, static fn () => new ResponseFactory());
$container->set(ServerRequestFactoryInterface::class, static fn () => new ServerRequestFactory());
$container->set(IndexAction::class, static fn () => new IndexAction());

// Cache and persistence use deterministic in-memory defaults; DATABASE_URL selects a real provider.
$container->set(CacheItemPoolInterface::class, static fn () => new ArrayAdapter());
$container->set(CacheInterface::class, static fn (Container $c) => new Psr16Cache($c->get(CacheItemPoolInterface::class)));
$container->set('fight.cache', static fn (Container $c) => new PsrCache($c->get(CacheItemPoolInterface::class), $c->get('logger')));
$container->set('persistence.connection', static fn (Container $c) => DriverManager::getConnection((new DsnParser(['sqlite' => 'pdo_sqlite']))->parse($c['app.database_url'])));
$container->set('event_store', static fn () => new InMemoryEventStore(new EventMapper([])));

// Synchronous and asynchronous messaging both remain local until a transport is configured.
$container->set('messaging.sync', static fn () => new MessageBus());
$container->set('messaging.transport', static fn () => new InMemoryTransport());
$container->set('messaging.async.command', static fn (Container $c) => new MessengerCommandBus($c->get('messaging.transport')));
$container->set('messaging.async.event', static fn (Container $c) => new MessengerEventDispatcher($c->get('messaging.transport')));

// Files, transfer, HTTP, and PSR-18 composition.
$container->set('filesystem', static fn (Container $c) => new Filesystem(new LocalFilesystemAdapter($c['app.storage_dir'])));
$container->set('file_storage', static fn (Container $c) => new FlysystemStorage($c->get('filesystem')));
$container->set('file_transfer', static fn () => new NullFileTransport());
$container->set('guzzle', static fn () => new Client(['http_errors' => false]));
ContainerCapabilityRegistrar::registerHttpClient($container, static fn (Container $c) => new GuzzleClient($c->get('guzzle')));
$container->set('psr18', static fn (Container $c): ClientInterface => $c->get(ClientInterface::class));

// Logging, observability, process, scheduler, mail, SMS, publication, and Twig fall back safely.
$container->set('logger', static function (): Logger { $logger = new Logger('slim'); $logger->pushHandler(new NullHandler()); return $logger; });
$container->set('health', static fn () => new HealthReporter());
$container->set('metrics', static fn () => new NullMetricsCollector());
$container->set('audit', static fn () => new NullAuditLog());
$container->set('process', static fn () => new Symfony\Component\Process\Process(['true']));
$container->set('scheduler', static fn () => new Schedule());
$container->set('mail', static fn () => new Mailer(Transport::fromDsn(getenv('MAILER_DSN') ?: 'null://null')));
$container->set('sms', static fn () => new NullSmsTransport());
$container->set('publication', static fn () => new \App\Platform\NullPublisher());
$container->set(Environment::class, static fn () => new Environment(new ArrayLoader(['profile' => 'Slim {{ value }}'])));
$container->set('twig', static fn (Container $c) => new TwigEngine($c->get(Environment::class)));
$container->set(Guard::class, static fn (Container $c) => new Guard($c->get(ResponseFactoryInterface::class)));

// Slim-bound services are lazy because routes are registered after the composition root boots.
$container->set('routing.named', static fn (Container $c) => new SlimUrlGenerator($c->get(App::class)->getRouteCollector(), new Slim\Psr7\Uri('http', 'localhost')));

return $container;
