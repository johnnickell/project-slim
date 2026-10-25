# Canonical quality gate

## Prepare explicitly, then verify

The host needs Python 3, a POSIX shell, Docker/Compose v2.20+, and `sha256sum` or `shasum`.
Use a feature checkout and the [checkout-owned runtime](../../README.md#development-runtime):

```sh
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/composer validate --strict
./bin/composer check-platform-reqs
./bin/up
./bin/build
```

`./bin/build` accepts no arguments. It never builds an image, starts services, installs/updates/audits dependencies,
refreshes planning, applies Rector fixes or formats source. Setup and maintenance are separate operations. Missing
Python, Docker, service, development tools, runtime or PCOV fail with prerequisite guidance; fix setup explicitly
and retry. Do not replace a failed coverage run with a non-coverage pass.

## Phase ownership and failures

The shell entrypoint resolves its own checkout and runs named **Planning** first on the **host**, using read-only
`./bin/planning-check`. This intentionally preserves TASK-00008's planning-before-Docker boundary. Neither Git
metadata nor the planning validator needs to be relocated into the container. Planning failure stops before Docker.

The wrapper then checks checkout/project ownership and requires the running `web` service. It delegates through
Compose exec to `php scripts/build.php`; no container-side `bin/*` wrapper is invoked. The PHP orchestrator runs:

1. **PHP runtime** — the existing executable/runtime-security guard, followed by development-tool/PCOV prerequisites.
2. **PHP syntax** — all root PHP files and PHP under `bootstrap/`, `config/`, `public/`, `scripts/`, `src/`, `tests/`.
3. **Fight PHPCS** — the installed Common v1.4.0 public ruleset, explicitly referenced by `phpcs.xml`.
4. **PHPStan** — maximum level with PHP 8.5.12 semantics and no baseline/ignored errors.
5. **Deptrac** — class, function and file dependencies, with uncovered dependencies reported and failing.
6. **Rector dry-run** — PHP upgrade rules through PHP 8.5, never rewriting source.
7. **PHPUnit / coverage** — exactly one no-argument `scripts/test.php` execution; that runner consumes its own reports.

Every subprocess inherits stdout/stderr. The first failed phase stops subsequent phases and preserves its positive
exit status (start/signal failures become nonzero). Warnings are not filtered. PHPCS warnings fail; PHPUnit warnings
and risky tests fail under `phpunit.xml`. Skips and coverage gaps remain visible. Generated reports/caches live under
ignored `var/`; PHPUnit also writes its ignored result cache. Concurrent gates in the same checkout share these
outputs: serialize them, or use separate checkout-owned runtimes.

## Scan scope and limits

PHPCS, PHPStan and Rector inspect **every `src/` PHP file**, currently the two HTTP adapters. PHPCS additionally
checks the new `scripts/build.php`, `deptrac.php` and `rector.php`. They do not scan upstream `vendor/`, test fixtures
or composition as application behavior. This initial scope avoids turning gate delivery into a repository-wide
legacy formatting/refactoring change. Syntax still covers all owned PHP, and Deptrac also inspects `config/`,
`bootstrap/` and `public/` as composition. This is not a claim that style/static analysis is enforced on tests,
composition or legacy tooling. There are no per-source exclusions, suppressed errors, baselines or disabled Fight
sniffs; PHPCS ignores suppression annotations. New application source belongs
under `src/`, not an excluded directory.

Deptrac models inward `Adapter → Application → Domain` dependencies and corresponding released Fight package layers.
Only Adapter/composition may depend on package adapters and named infrastructure namespaces. Composition may know
all layers. PHP internals are allowed; unknown external dependencies fail rather than fall into a catch-all layer.
Domain/Application have no owned source today: configured boundaries are not evidence of implemented business layers.
Deptrac's file emitter includes top-level composition references. Dependency graphs cannot establish that a use case
is justified, service location is appropriate, authorization is authoritative or an integration is secure; those
remain semantic review responsibilities. Dependencies inside `vendor/` are not analyzed as owned code.

Coverage uses the [existing single-run policy and denominator](TESTING.md#denominator-and-interpretation), without
an extra execution or threshold. Domain/Application are N/A; Adapter Unit gaps stay visible. Combined hits are not
Unit coverage. Reports are `var/coverage/full/{junit.xml,clover.xml,coverage.php,summary.json}`; never execute an
uploaded PHP coverage artifact.

## Qualified development tools

TASK-00009 selected these stable releases from public Composer metadata and directly ran them on the PHP 8.5.12
runtime and retained Common v1.4.0 / AccessControl v0.8.0 graph:

| Tool | Locked release | Contract used |
| --- | --- | --- |
| PHP_CodeSniffer | 4.0.4 | Common's published consumer ruleset workflow; warnings fail |
| Slevomat coding standard | 8.31.1 | Requires PHPCS `^4.0.4`; explicit standard loading |
| PHPStan | 2.3.2 | `analyse`, max level, PHP 80512 |
| Deptrac | 4.7.2 | PHP configuration API, class/function/file emitters, fail-on-uncovered |
| Rector | 2.7.0 | `RectorConfig::configure()`, `withPhpSets(php85: true)`, dry-run |
| PHPUnit / PCOV | 10.5.64 / 1.0.12 | Retained runner and image; one suite execution |

All existing lock entries are unchanged; 17 development packages are added. Slevomat's transitive Composer installer
plugin is explicitly disabled: the consumer ruleset loads standards directly, with no plugin execution required.
The two adapter type summaries were mechanically aligned to the released Fight grammar; their behavior is unchanged.
Future tool/lock upgrades require explicit maintenance and fresh qualification, not a build phase.

## Focused checks and hosted evidence

`./bin/phpunit [ARG ...]` remains focused test iteration, not a substitute for the full gate. For tool iteration use:

```sh
./bin/exec vendor/bin/phpcs --standard=phpcs.xml -s
./bin/exec vendor/bin/phpstan analyse --configuration=phpstan.neon --no-progress
./bin/exec vendor/bin/deptrac analyse --config-file=deptrac.php --no-progress --report-uncovered --fail-on-uncovered --formatter=table
./bin/exec vendor/bin/rector process --config=rector.php --dry-run --no-progress-bar
```

`.github/workflows/build.yml` explicitly prepares Python and the development lock, validates Composer/platform,
starts `web`, then invokes the same `./bin/build`. It uploads available non-executable coverage/test reports and
stops only the checkout-owned runtime, including on failure. Setup failures are not gate passes.

A local pass does **not** satisfy TASK-00009 AC-05, TICKET-00011 or EPIC-00001's required hosted proof. Actual hosted
execution on the selected lock remains required before TASK completion; independent review and authorized draft
publication may obtain it. No hosted result, PR publication, independent acceptance or merge is implied by this file.
Retired dependency matrices, receipts and no-dev certification remain retired.
