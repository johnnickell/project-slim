<?php

declare(strict_types=1);

// bin/build owns the read-only host planning phase before any Docker access.
// This orchestrator owns only the subsequent running-service PHP phases.
$root = dirname(__DIR__);
chdir($root);

$runPhase = static function (string $name, array $command): void {
    printf("\n==> %s\n", $name);
    $process = proc_open($command, [STDIN, STDOUT, STDERR], $pipes);
    if (!is_resource($process)) {
        fwrite(STDERR, 'Cannot start phase: '.$name."\n");
        exit(1);
    }
    $exit = proc_close($process);
    if ($exit !== 0) {
        fwrite(STDERR, sprintf("FAIL: %s (exit %d)\n", $name, $exit));
        exit($exit > 0 ? $exit : 1);
    }
    printf("PASS: %s\n", $name);
};

$runPhase('PHP runtime', [PHP_BINARY, 'scripts/check-php-runtime.php']);
$required = [
    'autoload.php', 'bin/phpcs', 'bin/phpstan', 'bin/deptrac', 'bin/rector', 'bin/phpunit',
    'johnnickell/fight-common/src/Standards/Phpcs/ruleset.xml',
    'slevomat/coding-standard/SlevomatCodingStandard/ruleset.xml'
];
foreach ($required as $file) {
    if (!is_file($root.'/vendor/'.$file)) {
        fwrite(STDERR, 'Missing development dependency: vendor/'.$file."\n");
        fwrite(
            STDERR,
            "Run: ./bin/composer install --no-interaction --prefer-dist --no-progress (including dev dependencies).\n"
        );
        exit(1);
    }
}
if (!extension_loaded('pcov')) {
    fwrite(STDERR, "PCOV is required for canonical coverage. Rebuild/start the authorized runtime with ./bin/up.\n");
    exit(1);
}

// Lint all owned PHP, including composition, fixtures and tooling, never vendor or reports.
$files = glob($root.'/*.php');
foreach (['bootstrap', 'config', 'public', 'scripts', 'src', 'tests'] as $directory) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/'.$directory));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
}
sort($files);
$runPhase('PHP syntax ('.count($files).' files)', [PHP_BINARY, '-l', ...$files]);
$runPhase('Fight PHPCS', [PHP_BINARY, 'vendor/bin/phpcs', '--standard=phpcs.xml', '-s']);
$runPhase('PHPStan', [PHP_BINARY, 'vendor/bin/phpstan', 'analyse', '--configuration=phpstan.neon', '--no-progress']);
$runPhase('Deptrac', [
    PHP_BINARY, 'vendor/bin/deptrac', 'analyse', '--config-file=deptrac.php', '--no-progress',
    '--report-uncovered', '--fail-on-uncovered', '--formatter=table'
]);
$runPhase('Rector dry-run', [
    PHP_BINARY, 'vendor/bin/rector', 'process', '--config=rector.php', '--dry-run', '--no-progress-bar'
]);
// The existing runner executes every suite once and consumes that same execution's coverage.
$runPhase('PHPUnit / coverage', [PHP_BINARY, 'scripts/test.php']);
printf("\nCanonical quality gate passed (host planning + running-service PHP).\n");
