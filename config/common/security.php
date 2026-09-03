<?php

declare(strict_types=1);

use Fight\Common\Adapter\Auth\Hmac\HmacRequestService;
use Fight\Common\Adapter\Auth\Security\PhpPasswordHasher;
use Fight\Common\Adapter\Auth\Security\PhpPasswordValidator;
use Fight\Common\Adapter\Auth\Security\JwtDecoder;
use Fight\Common\Adapter\Auth\Security\JwtEncoder;
use Fight\Common\Application\Auth\RequestService;
use Fight\Common\Application\Auth\Security\PasswordHasher;
use Fight\Common\Application\Auth\Security\PasswordValidator;
use Fight\Common\Application\Auth\Security\TokenDecoder;
use Fight\Common\Application\Auth\Security\TokenEncoder;
use Fight\Common\Application\Service\Container;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;

return static function (Container $container): void {
    $secret = getenv('APP_HMAC_SECRET') ?: str_repeat('a1', 32);
    $container->set(ValidatorInterface::class, static fn (): ValidatorInterface => Validation::createValidator());
    $container->set(PasswordHasher::class, static fn (): PasswordHasher => new PhpPasswordHasher(PASSWORD_ARGON2ID));
    $container->set(PasswordValidator::class, static fn (): PasswordValidator => new PhpPasswordValidator(PASSWORD_ARGON2ID));
    $container->set(TokenEncoder::class, static fn (): TokenEncoder => new JwtEncoder($secret));
    $container->set(TokenDecoder::class, static fn (): TokenDecoder => new JwtDecoder($secret));
    $container->set(RequestService::class, static fn (): RequestService => new HmacRequestService(getenv('APP_HMAC_KEY') ?: 'local', $secret));
};
