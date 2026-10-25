# Behavioral suites and coverage

## Run and inspect

Use the released `composer.lock` and the [development runtime](../../README.md#development-runtime):

```sh
./bin/up                         # rebuilds the image, including pinned PCOV 1.0.12
./bin/phpunit                    # one all-suite execution, reports and coverage policy
./bin/phpunit --testsuite Unit   # focused iteration, not a full policy result
./bin/phpunit --filter HttpPipelineTest
./bin/phpunit --list-suites      # discovery only, no coverage claim
./bin/build                     # canonical gate; requires host Python 3 and running web
```

`bin/phpunit` and the [canonical gate](QUALITY-GATE.md) call `php scripts/test.php`. It starts PHPUnit **once**, using
`phpunit.xml`, PCOV enabled for `src/`, and fresh PHP coverage, Clover and JUnit outputs. After PHPUnit succeeds,
it reads those artifacts without executing tests again. JUnit ancestry supplies actual Unit/Integration/Functional
class membership; coverage records supply line hits. Duplicate executed tests, ambiguous class membership,
unattributed hits, unknown source boundaries or missing reports fail rather than silently drop evidence.
PHPUnit warnings and risky tests fail. Test failures preserve their nonzero exit and cannot leave a success summary.

Reports are ignored local output under `var/coverage/full/` (no arguments) or `var/coverage/focused/` (any arguments):

- `junit.xml`: actual test, assertion, error, failure and skip counts, with suite attribution;
- `coverage.php`: PHPUnit's native serialized line-to-test coverage; trusted local output, never accept an uploaded PHP artifact;
- `clover.xml`: combined coverage for standard consumers;
- `summary.json`: executed test IDs, scope, PHP/driver identity, denominator, per-file/per-layer separate suite hits,
  combined union, exact uncovered lines and policy result. Attribution overlaps and is **not additive**.

Each test execution clears its own prior report files before checking driver availability or invoking PHPUnit.
Copy evidence to TASK-owned `.runs/` scratch before another invocation if it must be preserved. Focused results do
not overwrite full results and never establish full-suite policy compliance. Informational PHPUnit options print
normal discovery/help output without generating a new report. Options are forwarded; do not disable coverage or
replace configuration/report paths when collecting canonical evidence. No-argument execution is the canonical test
entrypoint consumed by the gate, not a second coverage phase. There is no hidden adapter threshold.

The gate requires the already-running owned service and development dependencies, performs host planning first,
then delegates its PHP phases to `scripts/build.php`. It performs no Composer maintenance, rebuild or startup.
The focused wrapper uses the same test runner without the surrounding quality phases. Required hosted proof for
TASK-00009 remains separate from local success.
Missing PCOV is a hard failure with rebuild guidance, not a non-coverage fallback. PCOV reports executable **lines**,
not branch/path coverage. Its PECL version is pinned in the shared development/build Dockerfile; Composer packages
and the released lock are unchanged.

## Denominator and interpretation

The filter is every `src/**/*.php` file, including uncovered files; coverage-ignore annotations are disabled.
There are no file exclusions inside `src/`. Source outside Domain/Application/Adapter must be classified explicitly.
Outside the product denominator: `config/`, `bootstrap/` and `public/` are composition/entrypoints; `vendor/` is
upstream; `tests/` is fixtures/tests; `scripts/` and `bin/` are tooling. No generated product code currently exists.
Do not exclude future uncovered behavior merely to improve percentages.

The accepted [coverage policy](STANDARDS.md#behavior-tests-and-coverage) requires 100% meaningful Domain/Application
executable lines across the single run. Separate Unit coverage is reported, never inferred from that union.
Domain and Application currently do not exist: both are **N/A**, not 100%. Adapter gaps remain visible with 100%
a practical target. Semantic ownership and meaningful tests still require independent review.

TASK-00008's initial verified source denominator is 10 executable Adapter lines:

| File | Combined | Unit | Integration | Functional |
| --- | --- | --- | --- | --- |
| `src/Adapter/Http/IndexAction.php` | 2/2 | 0/2 | 0/2 | 2/2 |
| `src/Adapter/Http/SlimHttpExceptionMiddleware.php` | 8/8 | 8/8 | 1/8 | 8/8 |
| Total | 10/10 | 8/10 | 1/10 | 10/10 |

Unit gaps are IndexAction's response-write and return lines (currently 22 and 24), intentionally protected through
the real root HTTP interaction.
Integration's single line is middleware construction during application boot, not proof of its HTTP behavior.
Functional hits do not prove every branch: the unit status-boundary cases additionally protect the middleware's
range guard. No absent business layer, upstream package implementation or composition line is counted as owned
unit behavior. Full line coverage is neither protocol, security, real-provider delivery nor correctness proof.
Current error-message disclosure and malformed-JSON status remain unchanged and belong to TASK-00010.

## Test disposition inventory

Baseline: `690225d5a6bdb27bb6533fe8c328a3f05f98e031`, 26 tests / 152 assertions. This inventory covers every baseline
method and every added method. Final suites contain 30 executed cases / 98 assertions (Unit 6/16, Integration 18/68,
Functional 6/14). Count reduction in assertions mainly removes the broad service-instance checklist, not behavior.
Shared fixtures remain support code, not an executable suite or coverage denominator.

### Removed and narrowed non-behavior checks

| Baseline test or assertion | Disposition and replacement |
| --- | --- |
| `BootstrapTest::test_that_root_route_resolves_the_fight_common_container_service` | Remove duplicate root interaction; `HttpPipelineTest::test_the_native_slim_root_route_remains_available` preserves the identical observable response. |
| `ContainerContractsTest::test_the_booted_slim_container_exposes_selected_public_contracts` | Remove wiring-only `has`/object checklist. Real consumer effects below remain. No replacement PHPUnit tooling suite. Direct syntax/composition smoke and Composer commands validate setup, without claiming every registration is semantically verified. |
| `CommunicationJourneyTest` concrete mail/hub instance assertions and configured Mercure URL getter | Remove wiring/constructor checks. Preserve local-safe acceptance, configured mail content at the mailer boundary, actual public/private payload effects and missing-token rejection below. Configured endpoint construction remains a direct composition smoke check, not real remote delivery evidence. |
| `MessagingJourneyTest` synchronous concrete bus/dispatcher instance assertions | Remove implementation selection assertions; preserve dispatched command, query, event and filter effects. |
| Communication and observability `addToAssertionCount(1)` | Remove synthetic counts. Null-provider operations remain explicitly bounded acceptance smoke, not delivery or durable telemetry evidence. |

### Integration: retained consumer outcomes

Names below are methods on the named class in `tests/Integration/`.

| Class / method | Behavioral disposition and plausible regression caught |
| --- | --- |
| `CommunicationJourneyTest::test_default_mail_and_sms_fallbacks_accept_messages_without_external_delivery` | Retain local-safe mail/SMS acceptance and default hub's `local` publication result; catches broken fallback consumption. No actual provider delivery claim. |
| `CommunicationJourneyTest::test_configured_mail_transport_delivers_content_to_the_mailer_boundary` | Rewrite former `test_configured_mailer_branch_uses_a_null_dsn_without_contacting_a_provider`: record the actual rendered subject/body at the public mailer boundary. Catches accidentally selecting the null transport or losing content, without asserting mock call order. Real null-DSN acceptance moves to direct composition smoke; no remote delivery claim. |
| `CommunicationJourneyTest::test_publishers_preserve_public_and_private_update_payloads` | Rename/rewrite former configured-Mercure constructor test: a recording hub observes both payloads, topics and privacy flags; catches lost content or public/private reversal without network traffic. |
| `CommunicationJourneyTest::test_configured_mercure_hub_requires_an_explicit_jwt` | Retain missing-token rejection at the owned provider boundary, not a test of a config file. |
| `HttpRoutingAndPresentationJourneyTest::test_booted_guzzle_transport_and_psr18_view_use_a_test_local_response_queue` | Retain statuses, headers and body through public HTTP consumer contracts; catches broken transport integration. |
| `HttpRoutingAndPresentationJourneyTest::test_booted_slim_url_generator_twig_and_json_serializer_have_real_output` | Retain relative/absolute URLs, template output and restored serialized value; catches unusable consumer composition. |
| `MessagingJourneyTest::test_the_booted_container_routes_synchronous_fight_messages_through_handlers_subscribers_and_filters` | Retain command state, query result, subscriber state and filter observations through configured public buses. Fixture messages exercise supported consumer extension seams, not new product use cases or upstream internals. |
| `PersistenceAndStorageJourneyTest::test_booted_cache_contracts_store_read_and_clear_values` | Retain cache value transitions, read-through load-once effect and clear; catches incompatible cache views. |
| `PersistenceAndStorageJourneyTest::test_booted_dbal_unit_of_work_commits_and_rolls_back_transactions` | Retain actual committed row, absent rolled-back row and propagated failure; catches lost transaction guarantees. Test-local SQLite, not future production persistence qualification. |
| `PersistenceAndStorageJourneyTest::test_booted_local_storage_filesystem_and_null_transfer_have_safe_behavior_and_clean_up` | Retain stored bytes, existence/size, filesystem output, null transfer result and cleanup effects. |
| `SecurityAndValidationJourneyTest::test_booted_security_services_sign_requests_and_round_trip_jwts` | Retain signature/header shape, body digest, JWT claims and correct/wrong password outcomes through configured capabilities. Not a cryptographic audit or authenticated application journey. |
| `SecurityAndValidationJourneyTest::test_booted_native_validator_reports_valid_and_invalid_values` | Retain acceptance/rejection of independently specified email examples. |
| `SecurityPrerequisiteTest::test_jwt_encoder_requires_an_explicit_hmac_secret_when_resolved` | Rename class/file from `SecurityConfigurationTest`; retain runtime secret rejection. Silent/default signing credentials would fail. |
| `SecurityPrerequisiteTest::test_jwt_decoder_requires_an_explicit_hmac_secret_when_resolved` | Same move; retain runtime verification-secret rejection. |
| `SecurityPrerequisiteTest::test_hmac_request_service_requires_an_explicit_key_when_resolved` | Same move; retain missing-key rejection before a usable signing capability is exposed. |
| `SecurityPrerequisiteTest::test_hmac_request_service_requires_an_explicit_secret_when_resolved` | Same move; retain missing-secret rejection. These four protect owned security prerequisites, not configuration structure or container instance types. |
| `SystemAndObservabilityJourneyTest::test_booted_process_runner_and_scheduler_execute_local_work_and_remove_lock_artifacts` | Retain process output, executed job state and cleanup effect, not mock ordering. |
| `SystemAndObservabilityJourneyTest::test_booted_observability_contracts_aggregate_health_and_accept_null_sink_events` | Retain health report values and local null metrics/audit acceptance; no durable sink claim. |

### Functional: retained real HTTP boundary and test-local downstream probes

Both classes remain in `tests/Functional/Http/`; no new production route is added.

| Class / method | Behavioral disposition |
| --- | --- |
| `HttpPipelineTest::test_the_native_slim_root_route_remains_available` | Retain production GET `/` status and exact readiness body. Replaces duplicate BootstrapTest. |
| `HttpPipelineTest::test_a_state_changing_json_request_is_parsed_before_the_route_handles_it` | Retain parsed JSON response through real middleware using an existing test-local echo route. |
| `HttpPipelineTest::test_invalid_json_is_returned_as_a_jsend_error_response` | Retain current malformed JSON status/envelope regression. Current 500/raw syntax message is not endorsed as safe; TASK-00010 owns the change. |
| `HttpPipelineTest::test_downstream_failures_are_returned_as_jsend_error_responses` | Retain current failure status/envelope through an existing test-local failing handler. Message sanitization remains TASK-00010. |
| `ProductionRouteBoundaryTest::test_an_unknown_production_route_is_a_jsend_not_found_error` | Retain actual production 404 and envelope. |
| `ProductionRouteBoundaryTest::test_production_boot_exposes_no_proof_only_api_routes` | Retain both POST 404 outcomes for fixture-only paths; tests the public boundary, not route/config source structure. |

### Unit: added direct owned middleware behavior

`tests/Unit/Adapter/Http/SlimHttpExceptionMiddlewareTest.php` tests existing behavior without new production endpoints.
Expectations come from the middleware's existing response-preservation/error-mapping contract and HTTP error-code
range, not generated snapshots or upstream private implementation.

| Method | Behavioral disposition |
| --- | --- |
| `test_successful_downstream_response_is_preserved` | Add exact response preservation; catches swallowed/replaced responses and headers. |
| `test_http_exception_status_is_bounded` | Add four boundary examples: 399→500, 400→400, 599→599, 600→500, JSON content type and error envelope. Catches off-by-one status guards; does not lock in raw error text. |
| `test_unrelated_failure_is_left_to_the_outer_error_boundary` | Add non-HTTP exception propagation; catches accidental swallowing/misclassification. |

## Direct non-product checks

Validate tools with their owning commands, outside PHPUnit. For this slice, use `./bin/composer validate`,
`./bin/composer check-platform-reqs`, `./bin/exec php scripts/check-php-runtime.php`, direct PHP syntax checks,
`./bin/planning-check --write` followed by read-only `./bin/planning-check`, and `git diff --check`.
The canonical build validates the already-prepared runtime and quality phases without maintaining dependencies. Configuration smoke may boot the container directly
and inspect selected registrations without creating permanent product tests; record its scope and limitations.
The [quality-gate scope](QUALITY-GATE.md#scan-scope-and-limits) distinguishes application-source style/static checks
and product/composition dependency analysis from semantic verification; tools do not replace every removed wiring assertion. Do not restore certification, wrapper/configuration tests, fictional business layers or tests of
this coverage reporter to product suites.
