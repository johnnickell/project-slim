# Slim Architecture Boundary

Slim owns the `src/` composition root, explicit `Fight\Common\Application\Service\Container` definitions, routes, middleware, handlers, HTTP boundary, and future framework adapters. Fight Common and Fight AccessControl remain public Composer dependencies; copied Domain or Application trees and unpublished package internals are prohibited.

The bootstrap exposes only a public hello-world HTTP seam. Authentication, authorization, persistence, browser journeys, and production integrations require separate local tickets and evidence.
