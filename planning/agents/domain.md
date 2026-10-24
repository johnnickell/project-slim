# Slim architecture boundary

Slim owns routes, middleware, handlers, explicit Fight Common container definitions, HTTP, presentation, and future
adapters. Shared Fight packages are Composer dependencies only. Apply the
[ownership ADR](../adr/0001-application-ownership-and-orchestration.md) and
[engineering standards](../../docs/engineering/STANDARDS.md); use public package contracts directly and add owned
orchestration only for demonstrated Slim policy or real ownership crossings.
