<?php

declare(strict_types=1);

namespace Tests\Integration;

use Fight\Common\Application\Mail\MailService;
use Fight\Common\Application\Sms\SmsService;
use Fight\Common\Application\Socket\PrivatePublisher;
use Fight\Common\Application\Socket\Publisher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Tests\Fixture\Security\Environment;
use Tests\Fixture\Socket\RecordingHub;

final class CommunicationJourneyTest extends TestCase
{
    protected function tearDown(): void
    {
        Environment::clear('MAILER_DSN');
        Environment::clear('MERCURE_URL');
        Environment::clear('MERCURE_JWT');
    }

    public function test_default_mail_and_sms_fallbacks_accept_messages_without_external_delivery(): void
    {
        Environment::clear('MAILER_DSN');
        Environment::clear('MERCURE_URL');
        Environment::clear('MERCURE_JWT');
        $container = (require sprintf('%s/bootstrap/app.php', dirname(__DIR__, 2)))->getContainer();

        self::assertSame('local', $container->get(HubInterface::class)->publish(new Update('local-topic', 'safe local update')));
        $container->get(MailService::class)->send($container->get(MailService::class)->createMessage());
        $container->get(SmsService::class)->send($container->get(SmsService::class)->createMessage('+15555550100', '+15555550101', 'safe local sms'));
    }

    public function test_configured_mail_transport_delivers_content_to_the_mailer_boundary(): void
    {
        putenv('MAILER_DSN=null://null');
        $container = (require sprintf('%s/bootstrap/app.php', dirname(__DIR__, 2)))->getContainer();
        $mailer = new class implements MailerInterface {
            public array $messages = [];

            public function send(RawMessage $message, ?Envelope $envelope = null): void
            {
                $this->messages[] = $message->toString();
            }
        };
        $container->set(MailerInterface::class, static fn (): MailerInterface => $mailer);
        $message = $container->get(MailService::class)->createMessage()
            ->addFrom('from@example.test')
            ->addTo('to@example.test')
            ->setSubject('Capability journey')
            ->addContent('safe local mailer', 'text/plain');
        $container->get(MailService::class)->send($message);

        self::assertCount(1, $mailer->messages);
        self::assertStringContainsString('Subject: Capability journey', $mailer->messages[0]);
        self::assertStringContainsString('safe local mailer', $mailer->messages[0]);
    }

    public function test_publishers_preserve_public_and_private_update_payloads(): void
    {
        $container = (require sprintf('%s/bootstrap/app.php', dirname(__DIR__, 2)))->getContainer();

        $recordingHub = new RecordingHub();
        $container->set(HubInterface::class, static fn (): RecordingHub => $recordingHub);
        $container->get(Publisher::class)->push('public-topic', 'public-message');
        $container->get(PrivatePublisher::class)->pushPrivate('private-topic', 'private-message');

        self::assertCount(2, $recordingHub->updates);
        self::assertFalse($recordingHub->updates[0]->isPrivate());
        self::assertTrue($recordingHub->updates[1]->isPrivate());
        self::assertSame(['public-topic'], $recordingHub->updates[0]->getTopics());
        self::assertSame('public-message', $recordingHub->updates[0]->getData());
        self::assertSame(['private-topic'], $recordingHub->updates[1]->getTopics());
        self::assertSame('private-message', $recordingHub->updates[1]->getData());
    }

    public function test_configured_mercure_hub_requires_an_explicit_jwt(): void
    {
        putenv('MERCURE_URL=https://mercure.example.test/.well-known/mercure');
        Environment::clear('MERCURE_JWT');
        $container = (require sprintf('%s/bootstrap/app.php', dirname(__DIR__, 2)))->getContainer();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('MERCURE_JWT must be configured when MERCURE_URL is set.');

        $container->get(HubInterface::class);
    }
}
