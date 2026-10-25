<?php

declare(strict_types=1);

use SebastianBergmann\CodeCoverage\CodeCoverage;

// One PHPUnit process produces both behavioral results and attributable coverage.
$root = dirname(__DIR__);
chdir($root);
require $root.'/vendor/autoload.php';

$arguments = array_slice($argv, 1);
$informational = array_intersect($arguments, ['--help', '--version', '--list-tests', '--list-tests-xml', '--list-suites', '--list-groups']);
$focused = $arguments !== [];
$directory = $root.'/var/coverage/'.($focused ? 'focused' : 'full');

if ($informational === []) {
    if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
        throw new RuntimeException('Cannot create coverage output directory.');
    }

    // Never consume a successful earlier run after a failed or interrupted invocation.
    foreach (['coverage.php', 'clover.xml', 'junit.xml', 'summary.json'] as $artifact) {
        if (is_file($directory.'/'.$artifact) && !unlink($directory.'/'.$artifact)) {
            throw new RuntimeException('Cannot clear prior coverage artifact.');
        }
    }
    if (!extension_loaded('pcov')) {
        fwrite(STDERR, "PCOV is required. Rebuild the authorized runtime with ./bin/up; do not substitute a non-coverage pass.\n");
        exit(1);
    }
}

$command = [PHP_BINARY, '-d', 'pcov.enabled=1', '-d', 'pcov.directory='.$root.'/src', $root.'/vendor/bin/phpunit', ...$arguments];
if ($informational === []) {
    array_push($command, '--coverage-php', $directory.'/coverage.php', '--coverage-clover', $directory.'/clover.xml', '--log-junit', $directory.'/junit.xml');
}

$process = proc_open($command, [STDIN, STDOUT, STDERR], $pipes);
if (!is_resource($process)) {
    throw new RuntimeException('Cannot start PHPUnit.');
}
$exit = proc_close($process);
if ($exit !== 0 || $informational !== []) {
    exit($exit);
}

if (!is_file($directory.'/coverage.php') || !is_file($directory.'/junit.xml')) {
    fwrite(STDERR, "PHPUnit did not produce the required coverage and suite reports.\n");
    exit(1);
}

// This is our fresh, local PHPUnit artifact, not an untrusted uploaded PHP report.
$coverage = require $directory.'/coverage.php';
if (!$coverage instanceof CodeCoverage) {
    throw new RuntimeException('Invalid PHPUnit coverage artifact.');
}
$junit = new DOMDocument();
if (!$junit->load($directory.'/junit.xml', LIBXML_NONET)) {
    throw new RuntimeException('Invalid PHPUnit JUnit artifact.');
}
$xpath = new DOMXPath($junit);
$suiteNames = ['Unit', 'Integration', 'Functional'];
$suites = array_fill_keys($suiteNames, ['tests' => 0, 'assertions' => 0]);
$testSuites = [];
$testClasses = [];
foreach ($xpath->query('//testcase') as $test) {
    $suite = $test->parentNode;
    while ($suite instanceof DOMElement && !in_array($suite->getAttribute('name'), $suiteNames, true)) {
        $suite = $suite->parentNode;
    }
    if (!$suite instanceof DOMElement) {
        throw new RuntimeException('Test is outside the configured behavioral suites.');
    }
    $name = $suite->getAttribute('name');
    $class = $test->getAttribute('class');
    if (isset($testClasses[$class]) && $testClasses[$class] !== $name) {
        throw new RuntimeException('A test class belongs to multiple suites: '.$class);
    }
    $testClasses[$class] = $name;
    $id = $class.'::'.$test->getAttribute('name');
    if (isset($testSuites[$id])) {
        throw new RuntimeException('A test executed more than once: '.$id);
    }
    $testSuites[$id] = $name;
    $suites[$name]['tests']++;
    $suites[$name]['assertions'] += (int) $test->getAttribute('assertions');
}
if ($testSuites === []) {
    throw new RuntimeException('No behavioral tests executed; no coverage result is claimed.');
}

$summary = [
    'scope' => $focused ? 'focused (not a full policy result)' : 'all configured suites',
    'generated_at' => gmdate(DATE_ATOM),
    'php' => PHP_VERSION,
    'driver' => 'PCOV '.phpversion('pcov'),
    'arguments' => $arguments,
    'suites' => $suites,
    'executed_tests' => array_keys($testSuites),
    'denominator' => 'All executable lines in src/**/*.php, including uncovered files; coverage-ignore annotations disabled',
    'excluded' => ['config/ (composition)', 'bootstrap/ (composition)', 'public/ (entrypoint)', 'vendor/ (upstream)', 'tests/ (fixtures and tests)', 'scripts/ and bin/ (tooling)'],
    'layers' => [],
    'files' => [],
];
$emptyCounts = ['executable' => 0, 'combined' => 0, 'Unit' => 0, 'Integration' => 0, 'Functional' => 0];
foreach (['Domain', 'Application', 'Adapter'] as $layer) {
    $summary['layers'][$layer] = $emptyCounts;
}
foreach ($coverage->getData()->lineCoverage() as $file => $lines) {
    if (!str_starts_with($file, $root.'/src/')) {
        throw new RuntimeException('Unexpected source in coverage denominator: '.$file);
    }
    $relative = substr($file, strlen($root) + 1);
    $layer = explode('/', substr($relative, 4))[0];
    // Unknown owned boundaries must be classified explicitly, never silently excluded.
    if (!isset($summary['layers'][$layer])) {
        throw new RuntimeException('Unclassified source boundary: '.$relative);
    }
    $counts = $emptyCounts;
    $gaps = array_fill_keys(['combined', ...$suiteNames], []);
    foreach ($lines as $line => $tests) {
        if ($tests === null) {
            continue;
        }
        $counts['executable']++;
        $attributed = [];
        foreach ($tests as $id) {
            // PHPUnit's coverage and JUnit formats spell data-set IDs differently.
            // Actual JUnit ancestry gives unambiguous class-to-suite membership for both.
            $class = explode('::', $id, 2)[0];
            if (!isset($testClasses[$class])) {
                throw new RuntimeException('Unattributed coverage test: '.$id);
            }
            $attributed[$testClasses[$class]] = true;
        }
        foreach (['combined' => $tests !== [], ...array_fill_keys($suiteNames, false)] as $name => $hit) {
            if ($hit || isset($attributed[$name])) {
                $counts[$name]++;
            } else {
                $gaps[$name][] = $line;
            }
        }
    }
    $summary['files'][$relative] = ['lines' => $counts, 'uncovered_lines' => $gaps];
    foreach ($counts as $name => $count) {
        $summary['layers'][$layer][$name] += $count;
    }
}

$policyPassed = true;
foreach ($summary['layers'] as $layer => $counts) {
    $total = $counts['executable'];
    $summary['layers'][$layer]['policy'] = $total === 0 ? 'N/A (no executable behavior)' :
        ($layer === 'Adapter' ? 'Gaps visible; 100% practical target' : '100% combined meaningful executable lines required');
    if ($layer !== 'Adapter' && $counts['combined'] !== $total) {
        $policyPassed = false;
    }
    printf("%s: %s\n", $layer, $total === 0 ? 'N/A (no executable behavior)' : sprintf(
        'combined %d/%d; Unit %d/%d; Integration %d/%d; Functional %d/%d executable lines',
        $counts['combined'], $total, $counts['Unit'], $total, $counts['Integration'], $total, $counts['Functional'], $total
    ));
}
foreach ($suites as $name => $counts) {
    printf("%s: %d tests / %d assertions\n", $name, $counts['tests'], $counts['assertions']);
}
$summary['policy'] = $focused ? 'Not evaluated for a focused invocation' : ($policyPassed ? 'PASS (absent layers N/A)' : 'FAIL');
if (file_put_contents($directory.'/summary.json', json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)."\n") === false) {
    throw new RuntimeException('Cannot write coverage summary.');
}
printf("Coverage: %s; %s\nAttribution overlaps; combined coverage is not Unit coverage or correctness proof.\n", $directory.'/summary.json', $summary['policy']);
exit(!$focused && !$policyPassed ? 1 : 0);
