# Fight Slim Starter

Public Slim application composition for Fight libraries. First run
`./bin/composer install --no-interaction --prefer-dist --no-progress`, then run `./bin/up`. Open
[http://localhost:18086](http://localhost:18086) to receive `Fight Slim starter is ready.` `./bin/build` is the
canonical verification gate.

This is a foundation only. Login, persistence, browser journeys, releases, tags, Packagist publication, template enablement, and create-project distribution are intentionally excluded.

Verification uses the committed `composer.lock` and retained application/integration tests. Framework-support
receipts, lowest/latest certification lanes, upstream receipt readers and separate no-dev certification are
retired. A green build verifies this application on its selected lock; it makes no broader package-support claim.
Dependency upgrades remain explicit work.

## PHP runtime maintenance

The build and development images select `php:8.5.12-cli-bookworm`. Composer requires stable PHP 8.5 at least
8.5.12 and emulates 8.5.12 for dependency resolution; emulation does not patch the executable. The startup guard
and build check execute PHP and reject an older, missing or unsupported runtime. Build logs identify the image
actually run, and `composer check-platform-reqs` checks the real runtime rather than emulation.

After changing the baseline or security INI, rebuild and recreate your own development containers:

```sh
# Keep the same project identity for all wrappers; choose an unused port before starting.
export COMPOSE_PROJECT_NAME=project-slim-my-checkout
# Optional: isolate the build tag from other checkouts on a shared Docker daemon.
export PROJECT_SLIM_BUILD_IMAGE=project-slim-my-checkout-build
docker compose build --pull web
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/composer validate
./bin/composer check-platform-reqs
./bin/exec php scripts/check-php-runtime.php
./bin/up
./bin/build
```

`./bin/up` rebuilds and recreates changed services; rebuilding an image alone does not replace a running worker.
The default development port remains `127.0.0.1:18086`; Compose project naming does not isolate that port. Inventory
shared tags, ports and services first; use a local Compose override for a different port if needed. Never remove
another checkout's networks, images or containers. `./bin/down` must use the same project and Compose files as startup.
Worktree-safe lifecycle automation remains separate work.

### Session-upload follow-up

PHP's [October 21 advisory](https://www.php.net/archive/2026.php#2026-10-21-5) identifies 8.5.12 as the fix for
CVE-2026-109618 and CVE-2026-109619. The [October 23 follow-up](https://www.php.net/archive/2026.php#2026-10-23-1)
(CVE-2026-115560) additionally describes startup `php_binary`/`php_serialize` serialization switched to `php` at
runtime before `session_start()`, with session upload progress enabled. An upgrade alone is not a complete answer
to that follow-up.

The inspected starter uses the default `php` session serializer, does not start sessions or switch their serializer,
and has no session-upload-progress feature. We nevertheless disable `session.upload_progress.enabled` in startup INI
as a temporary precaution, enforced by the guard. This takes effect before request parsing, unlike an application
`ini_set()`. Keep it disabled until a separately verified upstream fix permits removal. Future session features or
runtime overrides require reassessment; this is neither evidence of compromise nor a production security audit.
