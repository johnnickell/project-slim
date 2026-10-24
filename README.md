# Fight Slim Starter

Public Slim application composition for Fight libraries. First run
`./bin/composer install --no-interaction --prefer-dist --no-progress`, then run `./bin/up`. Open
[http://localhost:18086](http://localhost:18086) to receive `Fight Slim starter is ready.` `./bin/build` is the
canonical verification gate.

This is a foundation only. Login, persistence, browser journeys, releases, tags, Packagist publication, template enablement, and create-project distribution are intentionally excluded.

Verification uses the committed `composer.lock` and retained application/integration tests. Framework-support
receipts, lowest/latest certification lanes, upstream receipt readers and separate no-dev certification are
retired. A green build verifies this application on its selected lock; it makes no broader package-support claim.
Dependency upgrades remain explicit work. The [released baseline](docs/engineering/DEPENDENCIES.md) records Common
v1.4.0, AccessControl v0.8.0, their public-contract qualification and the bounded security patch update.

The [ownership ADR](planning/adr/0001-application-ownership-and-orchestration.md),
[engineering standards](docs/engineering/STANDARDS.md) and [shared Pi workflow binding](docs/engineering/WORKFLOWS.md)
adopt the reusable Agent OS foundation without copying its domain. Container modules now follow its sorted callable
contract. The later frontend/login adoption remains planned, not implemented. Runtime isolation, generated planning
views, the expanded quality/coverage gate and opt-in safe HTTP errors retain their existing TASK ownership; their
acceptance is not implied by installing newer packages.
