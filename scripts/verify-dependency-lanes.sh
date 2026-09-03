#!/usr/bin/env sh
set -eu

project_root=$(CDPATH= cd -- "$(dirname "$0")/.." && pwd)
mode=${1:-verify}
candidate_reference=4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16

copy_lane() {
    target=$1
    for path in bootstrap composer.json config src templates tests phpunit.xml; do
        if [ -e "$project_root/$path" ]; then
            cp -R "$project_root/$path" "$target/"
        fi
    done
}

assert_runtime_graph() {
    lane_root=$1
    php -r '
        $lock = json_decode(file_get_contents($argv[1]), true, 512, JSON_THROW_ON_ERROR);
        $packages = array_merge($lock["packages"], $lock["packages-dev"] ?? []);
        $byName = [];
        foreach ($packages as $package) { $byName[$package["name"]] = $package; }
        $candidate = $byName["johnnickell/fight-common"] ?? null;
        if (($candidate["version"] ?? null) !== "dev-develop" || ($candidate["source"]["reference"] ?? null) !== $argv[2]) {
            fwrite(STDERR, "Fight Common candidate identity is not locked as required.\n");
            exit(1);
        }
        $runtimeAbsent = [
            "laravel/framework", "symfony/framework-bundle", "codeigniter4/framework", "cakephp/cakephp",
            "php-di/php-di", "php-di/slim-bridge", "slim/csrf", "slim/twig-view",
            "symfony/finder", "symfony/messenger", "symfony/scheduler", "twilio/sdk"
        ];
        foreach ($runtimeAbsent as $package) {
            if (isset($byName[$package])) {
                fwrite(STDERR, sprintf("Unselected package is present in dependency lane: %s\n", $package));
                exit(1);
            }
        }
        $manifest = json_decode(file_get_contents($argv[3]), true, 512, JSON_THROW_ON_ERROR);
        foreach (["php-di/php-di", "php-di/slim-bridge", "slim/csrf", "slim/twig-view", "symfony/console", "symfony/finder", "symfony/messenger", "symfony/scheduler", "twilio/sdk"] as $package) {
            if (isset($manifest["require"][$package])) {
                fwrite(STDERR, sprintf("Unselected package remains a direct dependency: %s\n", $package));
                exit(1);
            }
        }
    ' "$lane_root/composer.lock" "$candidate_reference" "$lane_root/composer.json"
}

if [ "$mode" = "refresh-lowest" ]; then
    lane_root=$(mktemp -d)
    trap 'rm -rf "$lane_root"' EXIT
    copy_lane "$lane_root"
    composer update --working-dir="$lane_root" --prefer-lowest --prefer-stable --no-interaction --no-progress
    assert_runtime_graph "$lane_root"
    cp "$lane_root/composer.lock" "$project_root/composer-lowest.lock"
    php -r 'echo hash_file("sha256", $argv[1]), PHP_EOL;' "$project_root/composer-lowest.lock" > "$project_root/composer-lowest.lock.sha256"
    exit 0
fi

if [ "$mode" != "verify" ]; then
    echo "Usage: scripts/verify-dependency-lanes.sh [verify|refresh-lowest]" >&2
    exit 2
fi

expected_lowest=$(tr -d '\r\n' < "$project_root/composer-lowest.lock.sha256")
actual_lowest=$(php -r 'echo hash_file("sha256", $argv[1]);' "$project_root/composer-lowest.lock")
if [ "$expected_lowest" != "$actual_lowest" ]; then
    echo "composer-lowest.lock digest has drifted." >&2
    exit 1
fi

for lane in latest lowest; do
    lane_root=$(mktemp -d)
    trap 'rm -rf "$lane_root"' EXIT HUP INT TERM
    copy_lane "$lane_root"
    if [ "$lane" = latest ]; then
        cp "$project_root/composer.lock" "$lane_root/composer.lock"
    else
        cp "$project_root/composer-lowest.lock" "$lane_root/composer.lock"
    fi
    before=$(php -r 'echo hash_file("sha256", $argv[1]);' "$lane_root/composer.lock")
    composer install --working-dir="$lane_root" --no-interaction --prefer-dist --no-progress
    after=$(php -r 'echo hash_file("sha256", $argv[1]);' "$lane_root/composer.lock")
    if [ "$before" != "$after" ]; then
        echo "$lane dependency lane changed its lock during install." >&2
        exit 1
    fi
    assert_runtime_graph "$lane_root"
    (
        cd "$lane_root"
        vendor/bin/phpunit \
            tests/BootstrapTest.php \
            tests/Integration/ContainerContractsTest.php \
            tests/Integration/MessagingJourneyTest.php \
            tests/Integration/ProviderJourneyTest.php \
            tests/Functional/Http/HttpPipelineTest.php
    )
    rm -rf "$lane_root"
    trap - EXIT HUP INT TERM
done
