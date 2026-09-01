<?php

declare(strict_types=1);

namespace Tests;

use App\Platform\NullPublisher;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\Messenger\Envelope;

final class PlatformProfileTest extends TestCase
{
    public function test_the_local_safe_platform_profile_boots_and_exercises_its_default_services(): void
    {
        $app = require sprintf('%s/bootstrap/app.php', dirname(__DIR__));
        $container = $app->getContainer();

        foreach ([
            'validator', 'security.password_hasher', 'fight.cache', 'persistence.connection', 'event_store',
            'messaging.sync', 'messaging.transport', 'messaging.async.command', 'messaging.async.event',
            'filesystem', 'file_storage', 'file_transfer', 'guzzle', 'logger', 'health', 'metrics', 'audit',
            'process', 'scheduler', 'routing.named', 'mail', 'sms', 'publication', 'twig',
        ] as $service) {
            self::assertTrue($container->has($service), $service);
            $container->get($service);
        }

        $cache = $container->get(CacheItemPoolInterface::class);
        $item = $cache->getItem('profile');
        $item->set('ready');
        $cache->save($item);
        self::assertSame('ready', $cache->getItem('profile')->get());
        self::assertInstanceOf(ClientInterface::class, $container->get('psr18'));
        self::assertSame('/', $container->get('routing.named')->generate('app.index'));
        self::assertSame('Slim ready', $container->get('twig')->render('profile', ['value' => 'ready']));

        $container->get('filesystem')->write('profile.txt', 'ready');
        self::assertSame('ready', $container->get('filesystem')->read('profile.txt'));
        self::assertSame('', $container->get('file_transfer')->retrieveFileContents('profile.txt'));
        $container->get('messaging.sync')->dispatch(new \stdClass());
        $container->get('messaging.transport')->send(new Envelope(new \stdClass()));

        $publisher = $container->get('publication');
        self::assertInstanceOf(NullPublisher::class, $publisher);
        $publisher->push('profile', 'ready');
        self::assertSame([['topic' => 'profile', 'message' => 'ready']], $publisher->messages());
    }
}
