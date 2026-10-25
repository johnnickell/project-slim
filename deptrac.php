<?php

declare(strict_types=1);

use Deptrac\Deptrac\Contract\Config\AnalyserConfig;
use Deptrac\Deptrac\Contract\Config\Collector\ClassLikeConfig;
use Deptrac\Deptrac\Contract\Config\Collector\DirectoryConfig;
use Deptrac\Deptrac\Contract\Config\Collector\PhpInteralConfig;
use Deptrac\Deptrac\Contract\Config\DeptracConfig;
use Deptrac\Deptrac\Contract\Config\EmitterType;
use Deptrac\Deptrac\Contract\Config\Layer;
use Deptrac\Deptrac\Contract\Config\Ruleset;

return static function (DeptracConfig $config): void {
    $config
        ->paths(__DIR__.'/src', __DIR__.'/config', __DIR__.'/bootstrap', __DIR__.'/public')
        ->analyser(AnalyserConfig::create([
            EmitterType::CLASS_TOKEN,
            EmitterType::FUNCTION_TOKEN,
            EmitterType::FILE_TOKEN
        ]))
        ->layers(
            $domain = Layer::withName('Domain')->collectors(DirectoryConfig::create('/src/Domain/')),
            $application = Layer::withName('Application')->collectors(DirectoryConfig::create('/src/Application/')),
            $adapter = Layer::withName('Adapter')->collectors(DirectoryConfig::create('/src/Adapter/')),
            $composition = Layer::withName('Composition')->collectors(
                DirectoryConfig::create('(?:^|/)(?:config|bootstrap|public)/')
            ),
            $packageDomain = Layer::withName('Package Domain')->collectors(
                ClassLikeConfig::create('^Fight\\(?:Common|AccessControl)\\Domain\\')
            ),
            $packageApplication = Layer::withName('Package Application')->collectors(
                ClassLikeConfig::create('^Fight\\(?:Common|AccessControl)\\Application\\')
            ),
            $packageAdapter = Layer::withName('Package Adapter')->collectors(
                ClassLikeConfig::create('^Fight\\(?:Common|AccessControl)\\Adapter\\')
            ),
            $infrastructure = Layer::withName('Infrastructure')->collectors(
                ClassLikeConfig::create('^(?:Doctrine|GuzzleHttp|Lcobucci|League|Monolog|Psr|Slim|Symfony|Twig)\\')
            ),
            $internals = Layer::withName('PHP internals')->collectors(PhpInteralConfig::create('.*'))
        )
        ->rulesets(
            Ruleset::forLayer($domain)->accesses($domain, $packageDomain, $internals),
            Ruleset::forLayer($application)->accesses(
                $application,
                $domain,
                $packageDomain,
                $packageApplication,
                $internals
            ),
            Ruleset::forLayer($adapter)->accesses(
                $adapter,
                $application,
                $domain,
                $packageDomain,
                $packageApplication,
                $packageAdapter,
                $infrastructure,
                $internals
            ),
            Ruleset::forLayer($composition)->accesses(
                $composition,
                $domain,
                $application,
                $adapter,
                $packageDomain,
                $packageApplication,
                $packageAdapter,
                $infrastructure,
                $internals
            )
        )
        ->cacheFile(__DIR__.'/var/cache/deptrac.cache');
};
