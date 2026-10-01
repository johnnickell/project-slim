# Local Development Runtime Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Fight Agent OS direction on shared resources, worktree test isolation, and HTTPS ingress integration
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

Open; interview paused pending Fight Agent OS direction. The following choices are accepted planning intent,
not an implemented runtime or a complete contract.

### Settled direction

- Normal `./bin/up` should make the complete application runtime available rather than require feature profiles
  for workers, scheduling, or realtime. Nginx, PHP-FPM, PHP-CLI worker, scheduler, MySQL, Redis, and Mercure have
  separate roles. This does not require a separate instance of every resource per worktree or authorize Slim
  to start or stop shared infrastructure. Developer dashboards are optional; one-off CLI helpers need no
  permanently running helper container.
- Browser access uses HTTPS through the planned shared custom-domain ingress. Application services stay on
  private networks, with Slim's Nginx providing the shared-ingress attachment.
- Mercure stays private. Browser subscriptions pass through the shared proxy and Slim's Nginx at the same
  browser origin as the application; PHP publishes over the private network. Both proxy hops must support
  long-lived SSE connections without buffering. Direct Mercure attachment to shared ingress is not selected.

### Deferred to Agent OS direction

Do not assume full per-worktree infrastructure isolation. Shared resources may include the database and Redis;
per-worktree isolated test databases may still be needed. Resource ownership, provisioning, naming, credentials,
data isolation, lifecycle and cleanup semantics remain undecided. Do not design that system independently here.

Certificate tooling, trust enrollment, TLS termination and upstream encryption also remain unresolved. HTTPS
approval does not approve plaintext upstream traffic, host trust changes, or a certificate implementation.

The inspected Fight Agent OS planning reference is WF-023, “Define local runtime and shared ingress topology,”
with implementation work in TASK-00063 and TASK-00072. Its accepted direction allows explicit private shared-resource
networks distinct from shared ingress and independently operated project stacks. Those implementation TASKs were
not started when inspected; planning is not evidence of a delivered integration contract. No local paths or
external implementation details are required to define Slim's boundary.

Resume when Agent OS supplies direction for the shared-resource/test-isolation boundary and ingress integration.
Then reconcile the remaining service, environment, health, persistence, and wrapper decisions before closure.
No TASK scope, implementation authority, resource provisioning, or production certification changes here.
