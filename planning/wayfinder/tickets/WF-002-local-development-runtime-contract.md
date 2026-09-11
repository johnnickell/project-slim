# Local Development Runtime Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** —

## Question

What complete, worktree-safe Docker contract makes the Slim starter easy to run and verify locally without claiming
production deployment readiness?

## Must decide

- Settle the responsibilities and process topology for Nginx, PHP-FPM, PHP-CLI workers, MySQL, Redis, Mercure, and
  Cron-triggered scheduling.
- Define health checks, startup dependencies, restart expectations, persistent and ephemeral volumes, and local
  network boundaries.
- Define ports, Compose project isolation, container and volume naming, and concurrent-worktree behavior.
- Define the responsibilities and lifecycle semantics of `./bin/up`, `./bin/down`, `./bin/build`, `./bin/phpunit`,
  `./bin/composer`, and `./bin/exec`.
- Enumerate the complete `.env.example` contract, including safe local defaults, required overrides, generated keys,
  and secret-handling guidance.
- Separate local-development certification from production deployment and operations requirements.
- Keep Swagger UI and operational dashboards local-only by default and fail closed outside development.

## Resolution boundary

This ticket may settle the local runtime topology, wrapper behavior, isolation contract, and environment surface. It
does not implement containers, select production infrastructure, expose product operations, or certify production
readiness. Exact versions, ports, probes, volumes, and variables remain fog until this ticket closes.

## Resolution

Open.
