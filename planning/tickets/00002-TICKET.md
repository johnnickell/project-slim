---
id: T-00002
prd: PRD-00002
title: Adopt Fight Common 1.2
status: done
blocked_by:
---

# Adopt Fight Common 1.2

## Outcome

Resolve a 1.2 candidate through Slim's Composer installation, activate only supported local capabilities, run
lowest/latest booted journeys, and commit the canonical support receipt.

## Acceptance Criteria

- [x] Composer resolves the exact Fight Common candidate `dev-develop` at `4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16` and commits its lockfile.
- [x] The local-safe profile boots explicit Fight-container composition, PSR services, named routing, cache, persistence, messaging, storage, HTTP, rendering, process, scheduling, and provider fallbacks.
- [x] `evidence/framework-support/receipt-v1.json`, `./bin/planning-check`, focused/full tests, and detached `./bin/build` evidence pass.

## Verification

Run documented lowest/latest Composer and booted journeys, receipt canonicalization, `./bin/planning-check`, and `./bin/build`.
