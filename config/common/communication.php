<?php

declare(strict_types=1);

use Fight\Common\Adapter\Mail\Null\NullMailTransport;
use Fight\Common\Adapter\Mail\Symfony\SymfonyMailFactory;
use Fight\Common\Adapter\Mail\Symfony\SymfonyMailTransport;
use Fight\Common\Adapter\Sms\Null\NullSmsTransport;
use Fight\Common\Adapter\Socket\MercureHubPublisher;
use Fight\Common\Adapter\Socket\PrivateMercureHubPublisher;
use Fight\Common\Application\Mail\MailService;
use Fight\Common\Application\Mail\Transport\MailTransport;
use Fight\Common\Application\Service\Container;
use Fight\Common\Application\Sms\SmsService;
use Fight\Common\Application\Sms\Transport\SmsTransport;
use Fight\Common\Application\Socket\PrivatePublisher;
use Fight\Common\Application\Socket\Publisher;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mercure\Hub;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Jwt\StaticTokenProvider;
use Symfony\Component\Mercure\MockHub;

return static function (Container $container): void {
    $container->set(MailerInterface::class, static fn (): MailerInterface => new Mailer(Transport::fromDsn(getenv('MAILER_DSN') ?: 'null://null')));
    $container->set(MailTransport::class, static fn (Container $c): MailTransport => getenv('MAILER_DSN') ? new SymfonyMailTransport($c->get(MailerInterface::class)) : new NullMailTransport());
    $container->set(MailService::class, static fn (Container $c): MailService => new MailService($c->get(MailTransport::class), new SymfonyMailFactory()));
    $container->set(SmsTransport::class, static fn (): SmsTransport => new NullSmsTransport());
    $container->set(SmsService::class, static fn (Container $c): SmsService => new SmsService($c->get(SmsTransport::class)));
    $container->set(HubInterface::class, static function (): HubInterface {
        $url = getenv('MERCURE_URL');
        if ($url) {
            $token = getenv('MERCURE_JWT');
            if (!is_string($token) || $token === '') {
                throw new RuntimeException('MERCURE_JWT must be configured when MERCURE_URL is set.');
            }

            return new Hub($url, new StaticTokenProvider($token));
        }

        return new MockHub('http://localhost/.well-known/mercure', new StaticTokenProvider('local-mercure-token'), static fn (): string => 'local');
    });
    $container->set(Publisher::class, static fn (Container $c): Publisher => new MercureHubPublisher($c->get(HubInterface::class)));
    $container->set(PrivatePublisher::class, static fn (Container $c): PrivatePublisher => new PrivateMercureHubPublisher($c->get(HubInterface::class)));
};
