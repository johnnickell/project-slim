# Fight Slim Starter

Public Slim application composition for Fight libraries. With Docker running and Docker Compose v2.20+ installed,
run `./bin/composer install --no-interaction --prefer-dist --no-progress`, then `./bin/up`. Open the printed
`http://127.0.0.1:<port>` URL to receive `Fight Slim starter is ready.` `./bin/build` remains the canonical
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

The wrappers require a POSIX shell, Docker with Compose v2.20+, and `sha256sum` or `shasum`. They resolve their own
physical checkout directory, so invoking `/path/to/checkout/bin/exec` from elsewhere still targets that checkout.
Start with a clean checkout (each worktree needs its own dependencies):

```sh
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/composer validate
./bin/composer check-platform-reqs
./bin/up
# Open the Development URL printed by up; the root text is unchanged.
./bin/exec php scripts/check-php-runtime.php
./bin/phpunit --filter HttpPipelineTest
./bin/build
./bin/exec php -r 'echo "ready\n";'
./bin/down
```

| Wrapper | Contract |
| --- | --- |
| `./bin/composer COMMAND [ARG ...]` | Explicit maintenance: builds the checkout image and runs a disposable CLI container, even before web/dependencies exist. No published ports or other services. Only an explicit Composer command installs/updates dependencies. |
| `./bin/up` | Requires `vendor/autoload.php`; builds and starts only `web`, waits for its running state, and prints its URL. This is not an HTTP health/readiness probe. A rebuild may recreate the container; use the newly printed URL after every up. |
| `./bin/exec COMMAND [ARG ...]` | Executes the exact argument vector in this project's running `web` service at `/app`, without a TTY; stdin works for pipelines. No implicit startup or dependency installation. Use `sh -c '...'` explicitly for shell expressions. |
| `./bin/phpunit [ARG ...]` | Requires running `web`, development PHPUnit and PCOV; runs PHPUnit once, then reports separate suite coverage from that run. Arguments select focused iteration; no arguments run all suites and the adopted coverage policy. No automatic install/start. |
| `./bin/build` | Read-only host planning first, then named fail-fast PHP syntax/style/static-analysis/architecture/Rector and one PHPUnit/coverage run in running `web`. No install, image build, service startup, planning refresh or source fixes. No arguments accepted. |
| `./bin/down` | Stops/removes only this project's containers and default network after ownership checks; already absent is safe. Never deletes volumes, images or orphan services. No options accepted by up/down. |

Exec, tests and Composer return the invoked command's exit status; Docker/build/setup failures are nonzero.
Missing Docker/daemon, dependencies or running service fail with setup guidance. Invalid inputs fail without
provisioning. `./bin/build` additionally requires host Python 3 for planning before Docker access. The
[quality-gate contract](docs/engineering/QUALITY-GATE.md) documents phase ownership, qualified tool versions, scan
scope and required hosted evidence. See [reports, denominator and test dispositions](docs/engineering/TESTING.md).

### Checkout identity, ports and cleanup

- The default Compose project is `slim-<hash>`: the first 16 lowercase hex characters of SHA-256 of the physical
  absolute checkout path (no trailing newline). Branch changes do not change it; moving a checkout does. Stop the
  old runtime **before** moving it. Each checkout image is `project-slim-dev:<hash>`, shared by setup and the running gate.
  Containers and the default network use Compose project-scoped names; no fixed container names or persistent
  volumes exist. Dependencies are a checkout-local bind mount, not shared between worktrees.
- Port `0` (default) asks Docker to allocate an available host port on **127.0.0.1 only**. `./bin/up` prints the
  current address; it may change on recreation. There is no fixed default 18086 port anymore. For a stable port,
  export `PROJECT_SLIM_HTTP_PORT=18086` (or another unused 1024–65535 port) before startup. Explicit duplicate
  port choices fail rather than evict another listener. No public-bind override is provided.
- Optionally export `COMPOSE_PROJECT_NAME=slim-my-checkout` (lowercase letters/digits/underscore/hyphen; start with a
  letter/digit). Keep the same value for **all** lifecycle/exec/test/maintenance invocations. Project overrides must
  be unique per concurrent checkout. Existing containers, networks or volumes with that project label but without
  this checkout's ownership label cause refusal, including resources made by the old unlabelled wrappers. Never
  adopt or delete them by guessing ownership; choose a new project name or obtain their owner's cleanup.
- Wrappers select only committed `compose.yaml`; ambient `COMPOSE_FILE`, profiles, `.env`, `.env.local` and automatic
  override files are not loaded. The two exported variables above are the supported configuration surface. Internal
  `PROJECT_SLIM_CHECKOUT`/`PROJECT_SLIM_RUNTIME_IMAGE` are derived, not user overrides. No secret or generated key is
  required for this plain starter; do not put credentials in shell history, logs or committed files. This is not
  the future application's complete environment contract.
- Before lifecycle actions, inventory containers, ports, networks and volumes (`docker ps -a`, `docker network ls`,
  `docker volume ls` and your host listener tool). Ownership labels `dev.fight.slim.checkout` identify the physical
  checkout; project labels alone are not proof. `down` refuses foreign/unlabelled project resources and does not
  remove durable data. Images are retained as a local cache. Volume/data deletion needs separate explicit authority;
  never use global prune or broad cleanup to resolve a collision.

For concurrent work, authorize/create a second Git worktree, repeat explicit setup there, then start both with
defaults. Their projects, images, bind mounts, networks and automatically allocated ports are distinct. Stop each
runtime from its own checkout with its original exports before removing an owned disposable worktree. No runtime
enrollment, shared-resource provisioning, TLS/trust change or production-readiness claim is involved.
[WF-002](planning/wayfinder/tickets/WF-002-local-development-runtime-contract.md) remains open/paused for the full topology.

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
