---
id: T-00006
prd: PRD-00002
title: Establish the Lean Slim Pre-Submit Quality Gate
status: ready-for-agent
blocked_by:
---

# Establish the Lean Slim Pre-Submit Quality Gate

## Outcome

Establish one Slim-owned lean `./bin/build` gate as the successor to Fight Common
[T-00087](https://github.com/johnnickell/fight-common/blob/develop/planning/tickets/00087-TICKET.md) and
[ADR 0026](https://github.com/johnnickell/fight-common/blob/develop/planning/adr/0026-lean-pre-submit-and-release-qualification.md).

## Scope

- Require `johnnickell/fight-common:^1.2`, the installed `FightCommon` PHPCS standard, and local scan
  paths/exclusions.
- `./bin/build` is the only local and hosted pre-submit gate; run every retained Unit, Integration, Functional,
  frontend, and browser suite once with Composer validation, syntax/formatting, PHPCS, PHPStan, Deptrac, and
  Rector dry-run.
- Direct Unit tests use `#[CoversClass]` and alone prove exact 100% owned-production statement coverage;
  retained boundary and journey suites use `#[CoversNothing]`.
- Retain Slim-native composition boundaries and valuable journeys while keeping framework types in
  Adapter/composition under Adapter -> Application -> Domain.

## Exclusions and Cleanup

- Replace the monolithic test topology and remove receipt/profile/lane fixtures and other Fight Common
  certification machinery from ordinary builds.
- Remove candidate validation, lowest/latest lanes, receipts and authorities, auxiliary locks/digests, clean
  production-install inspection, and Fight Common certification journeys.
- Never test build scripts, CI, configuration, coverage tooling, certification-only fixtures, receipts, or docs.
  Hosted CI invokes `./bin/build` only; hosted result is separate delivery evidence.

## Acceptance Criteria

- [ ] The one canonical gate runs each retained suite once plus all retained quality checks.
- [ ] Package/standard adoption, local paths/exclusions, and direct Unit-only exact coverage are enforced.
- [ ] Coverage metadata keeps direct Unit ownership separate from retained boundary and product journeys.
- [ ] Slim-native boundaries and valuable application journeys remain while receipt/profile/lane fixtures and
      monolithic certification topology are absent from ordinary builds.

## Verification

- Run focused retained checks and `./bin/build`.
- Verify CI delegates only to that command; keep its status separate from local evidence.
