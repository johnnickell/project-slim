<?php

declare(strict_types=1);

use Fight\Common\Adapter\Templating\TwigEngine;
use Fight\Common\Application\Service\Container;
use Fight\Common\Application\Templating\TemplateEngine;
use Fight\Common\Application\Serialization\JsonSerializer;
use Fight\Common\Domain\Serialization\Serializer;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

return static function (Container $container): void {
    $container->set(Environment::class, static fn (): Environment => new Environment(new ArrayLoader(['profile' => 'Slim {{ value }}'])));
    $container->set(TemplateEngine::class, static fn (Container $c): TemplateEngine => new TwigEngine($c->get(Environment::class)));
    $container->set(Serializer::class, static fn (): Serializer => new JsonSerializer());
};
