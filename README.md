# Fight Slim Starter

Public Slim application composition for Fight libraries. With Docker running and Docker Compose with native `!override` support installed,
run `./bin/composer install --no-interaction --prefer-dist --no-progress`, then `./bin/up`. Inspect `./bin/runtime docker compose ps` for the current loopback port and open that URL to receive `Fight Slim starter is ready.` `./bin/build` remains the canonical
verification gate. See [development runtime](#development-runtime) for setup, isolation and lifecycle semantics.

This is a foundation only. Login, persistence, browser journeys, releases, tags, Packagist publication, template enablement, and create-project distribution are intentionally excluded.

Verification uses the committed `composer.lock` and retained application/integration tests. Framework-support
receipts, lowest/latest certification lanes, upstream receipt readers and separate no-dev certification are
retired. A green build verifies this application on its selected lock; it makes no broader package-support claim.
Dependency upgrades remain explicit work. The [released baseline](docs/engineering/DEPENDENCIES.md) records Common
v1.4.0, AccessControl v0.8.0, their public-contract qualification and the bounded security patch update.

The [ownership ADR](planning/adr/0001-application-ownership-and-orchestration.md),
[engineering standards](docs/engineering/STANDARDS.md) and [shared Pi workflow binding](docs/engineering/WORKFLOWS.md)
adopt the reusable Agent OS foundation without copying its domain. Container modules now follow its sorted callable
contract. The later frontend/login adoption remains planned, not implemented. Planning views now refresh explicitly
with `./bin/planning-check --write`; default `./bin/planning-check` and the build reject drift without writing or
hosted access. [Land closeout](planning/CONVENTIONS.md#publication-closeout) owns accepted TASK/current-doc
closure, exact live PR validation and eligible owned local Git/Docker/storage retirement. Human merge remains
separate, without a tracked pending-merge queue or recurring post-merge planning chore; historical evidence stays.
The [TASK Board](planning/tickets/BOARD.md) is the sole execution view. New-only archive tooling requires a separately
requested, reviewed dry run and explicit apply; TASK-00002 performs no archives and does not dynamically verify apply.
TASK-00007 supplies isolation for the existing development service only. TASK-00008 supplies behavior-focused suites
and single-run, separately attributed line coverage; see [testing](docs/engineering/TESTING.md). TASK-00009 adds the
[running-service quality gate](docs/engineering/QUALITY-GATE.md); implementation A is independently accepted and
QA-passed with hosted evidence. Its metadata-only closeout B passed final delivery CI and PR #20 is merged;
[TASK-00009](planning/tasks/00009-TASK.md#post-merge-reconciliation--pr-20) retains the distinct acceptance and delivery provenance.
Opt-in safe HTTP errors remain TASK-00010; their acceptance is not implied by newer packages.

## Development runtime

Use [local tooling](docs/engineering/LOCAL_TOOLING.md) for the owning command contract, explicit main/worktree
selection, dynamic loopback ports, build caching and guarded teardown. The runtime remains the single existing
`web` service; full WF-002 topology stays open/paused. No ingress enrollment, TLS or production-readiness claim
is introduced. Each checkout owns its dependencies and generated coverage.

```sh
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/up --worktree "$PWD"       # Inside the selected registered isolated worktree
./bin/runtime docker compose ps  # Inspect the current published port
./bin/exec php scripts/check-php-runtime.php
./bin/phpunit --filter HttpPipelineTest
./bin/build
./bin/down --worktree "$PWD"
```

Without `--worktree`, up/down select main. Focused tooling inside a linked checkout automatically selects its
project. `bin/build` checks planning freshly, reuses only qualifying original application evidence, and accepts
`--force` for deliberate fresh execution. On a miss the existing quality phases and one PHPUnit/coverage run
remain unchanged; no dependency update or source fix is implicit. See the
[quality-gate contract](docs/engineering/QUALITY-GATE.md) and
[reports, denominator and test dispositions](docs/engineering/TESTING.md).

## PHP runtime maintenance

The development image, also used by the running-service gate, selects `php:8.5.12-cli-bookworm`. Composer requires stable PHP 8.5 at least
8.5.12 and emulates 8.5.12 for dependency resolution; emulation does not patch the executable. The startup guard
and gate check execute PHP and reject an older, missing or unsupported runtime. Explicit setup logs identify the
built image; the gate reports the running PHP version. `composer check-platform-reqs` checks the real runtime
rather than emulation during explicit setup and hosted preparation.

After changing the baseline or security INI, repeat explicit dependency setup, `./bin/up` and `./bin/build`.
`./bin/up` rebuilds the local development image and recreates changed services; an image rebuild alone does not
replace a running process. See the [runtime contract above](#development-runtime) for checkout/project ownership and overrides.

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

See [local Docker, worktree and build-cache operations](docs/engineering/LOCAL_TOOLING.md) for explicit main/worktree selection, guarded teardown and fresh versus reused gate evidence.
