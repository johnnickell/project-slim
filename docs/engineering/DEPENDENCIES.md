# Released dependency baseline

## Qualified on 2026-10-24

The manifest and committed lock select public stable releases, not development aliases:

| Package | Installed and locked release | Public source reference |
| --- | --- | --- |
| `johnnickell/fight-common` | v1.4.0 | `87b9580c072f3149d574e09865daa79620c92118` |
| `johnnickell/fight-access-control` | v0.8.0 | `319738255e682d587642b67856039f882b9588d6` |

Composer's final `show <package> --latest --format=json` reports these as the latest releases. Common 1.5 was not
available at this qualification; recheck at the next explicit upgrade rather than installing a development branch
or assuming its planned behavior. AccessControl v0.8 requires Common `^1.3`; the selected Common v1.4 satisfies it.
The root now requires Common `^1.4`, AccessControl `^0.8`, stable minimum stability and one committed lock.
Public VCS repositories are retained; no private path repository or copied library source is used.

Only those two packages changed in the initial update. An explicit audit then identified
[CVE-2026-108082](https://symfony.com/cve-2026-108082) / `PKSA-xmwy-rmx5-m7h4` in locked
`symfony/http-foundation` v8.1.6. A bounded patch update selected v8.1.9. The final audit reports no advisories or
abandoned packages, and strict Composer validation passes. These are time-bound maintenance results, not claims of
complete security or broader dependency support. No unrelated package updates were included.

## Public contracts and limits

- Existing container, messaging registrars, buses, service-aware routers, pipelines, HTTP factories and adapters
  remain compatible with the retained consumer journeys. Every registration module now returns a callable and
  command/query/event registrations use shared services. Direct configuration qualification is not a product test.
- AccessControl's installed `InvitePendingUserHandler` now requires
  `Fight\Common\Application\Repository\TransactionalUnitOfWork`, matching the capability Slim registers through
  `DoctrineTransactionalUnitOfWork(EntityManagerInterface)`. The interface declares
  `commitTransactional(callable): mixed` and `isClosed(): bool`. No consumer alias or deprecated `commit()` bridge
  is needed. This does not implement or qualify an invitation, repository, durable-delivery or authentication journey.
- Common v1.4 includes opt-in `SafeJSendErrorMiddleware`, `SafeHttpErrorPolicy`, `SafeHttpDiagnostics` and
  `SafeHttpFailure`. Its legacy `JSendErrorMiddleware` deliberately retains raw-message behavior. Updating Composer
  does not opt Slim into the safe boundary; TASK-00010 owns native exception/Allow mapping, malformed-JSON handling,
  redacted diagnostics and regression-tested wire changes. See installed `docs/safe-http-errors.md` before composing it.
- The public root remains `Fight Slim starter is ready.`. Existing integration/functional behavior passes on this
  lock. No claim covers unimplemented login, production persistence, browser flows, Common 2.0 or package internals.

## Explicit maintenance

Use the repository wrapper; maintenance is distinct from acceptance evidence:

```sh
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/composer show johnnickell/fight-common --latest
./bin/composer show johnnickell/fight-access-control --latest
./bin/composer update johnnickell/fight-common johnnickell/fight-access-control --with-dependencies --minimal-changes --no-interaction --prefer-dist --no-progress
./bin/composer audit
./bin/composer validate --strict
./bin/phpunit
./bin/build
```

Inspect candidate release signatures, the resulting lock diff, installed identities and actual retained behavior.
A new release is not automatically compatible. Add a specific additional package to the update only for an evidenced
reason; document it and re-run verification. Do not reintroduce lowest/latest lanes, no-dev checks, receipt readers or
framework certification. The [quality gate](QUALITY-GATE.md) uses the running service and never installs or audits
dependencies. TASK-00009's explicit tool maintenance adds development packages without changing any existing lock
entry; its qualified tool versions and hosted-proof limitation are recorded in that contract.
