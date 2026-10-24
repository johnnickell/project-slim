# Slim Architecture Boundary

Slim owns the `src/` composition root, explicit `Fight\Common\Application\Service\Container` definitions, routes, middleware, handlers, HTTP boundary, and future framework adapters. Fight Common and Fight AccessControl remain public Composer dependencies; copied Domain or Application trees and unpublished package internals are prohibited.

Adopt the reusable Fight Agent OS foundation one-to-one by default, excluding its domain-specific behavior. The
[accepted ownership ADR](planning/adr/0001-application-ownership-and-orchestration.md) and
[engineering standards](docs/engineering/STANDARDS.md) govern composition, naming, HTTP, testing and delivery.
Every sorted `config/{parameters,common,application}/*.php` module returns one registration callable; command/query/
event modules own their shared pipelines. New application services extend this graph rather than replacing buses.

The bootstrap exposes only a public hello-world HTTP seam. Authentication, authorization, persistence, browser journeys,
and production integrations require separate local tickets and evidence. The completed Agent OS frontend/login flow
and applicable tests are the intended later adoption source, not permission to copy unfinished product behavior now.
