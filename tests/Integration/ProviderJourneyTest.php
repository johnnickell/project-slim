<?php

declare(strict_types=1);

namespace Tests\Integration;

use Doctrine\DBAL\Connection;
use Fight\Common\Adapter\Cache\PsrCache;
use Fight\Common\Application\Auth\Security\PasswordHasher;
use Fight\Common\Application\Auth\Security\PasswordValidator;
use Fight\Common\Application\Auth\Security\TokenDecoder;
use Fight\Common\Application\Auth\Security\TokenEncoder;
use Fight\Common\Application\FileStorage\FileStorage;
use Fight\Common\Application\FileStorage\StorageService;
use Fight\Common\Application\FileTransfer\FileTransferService;
use Fight\Common\Application\Filesystem\Filesystem;
use Fight\Common\Application\Mail\MailService;
use Fight\Common\Application\Sms\SmsService;
use Fight\Common\Application\Socket\PrivatePublisher;
use Fight\Common\Application\Socket\Publisher;
use Fight\Common\Application\Templating\TemplateEngine;
use Fight\Common\Application\Process\ProcessBuilder;
use Fight\Common\Application\Process\ProcessRunner;
use Fight\Common\Application\Repository\TransactionalUnitOfWork;
use Fight\Common\Application\Scheduler\Scheduler;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Mercure\HubInterface;
use Tests\Fixture\Socket\RecordingHub;
use DateTimeImmutable;

final class ProviderJourneyTest extends TestCase
{
    public function test_local_safe_providers_have_observable_behavior_and_clean_up_after_themselves(): void
    {
        $container = (require sprintf('%s/bootstrap/app.php', dirname(__DIR__, 2)))->getContainer();

        $cache = $container->get(CacheInterface::class);
        $cache->set('provider-journey', 'cached');
        self::assertSame('cached', $cache->get('provider-journey'));
        self::assertInstanceOf(PsrCache::class, $container->get(PsrCache::class));

        $connection = $container->get(Connection::class);
        $connection->executeStatement('CREATE TABLE profile_journey (value TEXT NOT NULL)');
        $unitOfWork = $container->get(TransactionalUnitOfWork::class);
        $unitOfWork->commitTransactional(static function () use ($connection): void { $connection->insert('profile_journey', ['value' => 'committed']); });
        try {
            $unitOfWork->commitTransactional(static function () use ($connection): void { $connection->insert('profile_journey', ['value' => 'rolled-back']); throw new \RuntimeException('rollback'); });
        } catch (\RuntimeException) {
        }
        self::assertSame(['committed'], $connection->fetchFirstColumn('SELECT value FROM profile_journey'));

        $storage = $container->get(FileStorage::class);
        $path = sprintf('journeys/%s.txt', bin2hex(random_bytes(6)));
        $storage->putFile($path, 'stored');
        self::assertSame('stored', $storage->getFileContents($path));
        $storage->removeFile($path);
        self::assertFalse($storage->hasFile($path));

        $storageService = $container->get(StorageService::class);
        self::assertSame($storage, $storageService->getStorage('local'));
        self::assertSame($container->get(\Fight\Common\Application\FileTransfer\Transport\FileTransport::class), $container->get(FileTransferService::class)->getTransport('null'));

        $filesystem = $container->get(Filesystem::class);
        $localPath = sprintf('%s/var/provider-%s.txt', dirname(__DIR__, 2), bin2hex(random_bytes(6)));
        $filesystem->put($localPath, 'filesystem');
        self::assertSame('filesystem', $filesystem->get($localPath));
        $filesystem->remove($localPath);
        self::assertFalse($filesystem->exists($localPath));

        $output = '';
        $runner = $container->get(ProcessRunner::class);
        $runner->attach(ProcessBuilder::create()->shellCommand('printf provider-process')->stdout(static function (string $data) use (&$output): void { $output .= $data; })->getProcess());
        $runner->run();
        self::assertSame('provider-process', $output);
        $ran = false;
        $scheduler = $container->get(Scheduler::class);
        $scheduler->addJob('provider-journey', static fn (): bool => true, static function () use (&$ran): bool { $ran = true; return true; });
        $scheduler->run();
        self::assertTrue($ran);

        $hasher = $container->get(PasswordHasher::class);
        self::assertTrue($container->get(PasswordValidator::class)->validate('secret', $hasher->hash('secret')));
        $token = $container->get(TokenEncoder::class)->encode(['subject' => 'provider-journey'], new DateTimeImmutable('+5 minutes'));
        self::assertSame('provider-journey', $container->get(TokenDecoder::class)->decode($token)['subject']);
        self::assertSame('Slim ready', $container->get(TemplateEngine::class)->render('profile', ['value' => 'ready']));

        $container->get(MailService::class)->send($container->get(MailService::class)->createMessage());
        $container->get(SmsService::class)->send($container->get(SmsService::class)->createMessage('+15555550100', '+15555550101', 'safe'));

        $hub = new RecordingHub();
        $container->set(HubInterface::class, static fn (): RecordingHub => $hub);
        $container->get(Publisher::class)->push('public-topic', 'public-message');
        $container->get(PrivatePublisher::class)->pushPrivate('private-topic', 'private-message');
        self::assertCount(2, $hub->updates);
        self::assertFalse($hub->updates[0]->isPrivate());
        self::assertTrue($hub->updates[1]->isPrivate());
    }
}
