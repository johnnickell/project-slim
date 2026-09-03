<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../../scripts/framework-support-receipt.php';

final class FrameworkSupportReceiptTest extends TestCase
{
    public function test_the_committed_receipt_is_canonical_and_describes_the_current_candidate_and_lock(): void
    {
        $root = dirname(__DIR__, 2);
        $path = $root.'/evidence/framework-support/receipt-v1.json';
        $receipt = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        self::assertSame(['schema_version', 'content_id', 'candidate', 'framework', 'lock_sha256', 'capabilities', 'journeys', 'result', 'evidence', 'next_action'], array_keys($receipt));
        self::assertSame(FRAMEWORK_SUPPORT_SCHEMA, $receipt['schema_version']);
        self::assertSame(['package' => FIGHT_COMMON_PACKAGE, 'version' => FIGHT_COMMON_VERSION, 'reference' => FIGHT_COMMON_REFERENCE], $receipt['candidate']);
        self::assertSame('slim', $receipt['framework']['name']);
        self::assertSame(hash_file('sha256', $root.'/composer.lock'), $receipt['lock_sha256']);
        self::assertSame(frameworkSupportCanonicalJson($receipt), (string) file_get_contents($path));
        self::assertSame(frameworkSupportCanonicalJson(frameworkSupportReceipt($root)), (string) file_get_contents($path));
        self::assertSame(frameworkSupportContentId($receipt), $receipt['content_id']);
        self::assertSame(frameworkSupportReceiptDigest($receipt), $receipt['evidence']['receipt_sha256']);

        foreach ($receipt['capabilities'] as $state) {
            self::assertContains($state, ['ship', 'wire', 'unavailable']);
        }
        foreach ($receipt['journeys'] as $journey) {
            self::assertSame(['name', 'status', 'evidence'], array_keys($journey));
            self::assertContains($journey['status'], ['passed', 'failed', 'unavailable', 'skipped', 'indeterminate']);
        }
        self::assertSame('passed', $receipt['result']);
        self::assertNull($receipt['next_action']);
        self::assertTrue(array_all($receipt['journeys'], static fn (array $journey): bool => $journey['status'] === 'passed'));
    }

    public function test_receipt_hashes_and_outcomes_fail_closed_when_the_document_is_mutated(): void
    {
        $root = dirname(__DIR__, 2);
        $receipt = json_decode((string) file_get_contents($root.'/evidence/framework-support/receipt-v1.json'), true, flags: JSON_THROW_ON_ERROR);
        $receipt['capabilities']['messaging.synchronous'] = 'invented';
        self::assertNotContains($receipt['capabilities']['messaging.synchronous'], ['ship', 'wire', 'unavailable']);
        self::assertNotSame(frameworkSupportContentId($receipt), $receipt['content_id']);

        $receipt['result'] = 'failed';
        $receipt['next_action'] = null;
        self::assertFalse(self::hasCanonicalOutcome($receipt));

        $receipt['journeys'][0]['status'] = 'failed';
        $receipt['next_action'] = ['action' => 'Repair the failed journey.'];
        self::assertTrue(self::hasCanonicalOutcome($receipt));
    }

    /** @param array{result: string, journeys: list<array{name: string, status: string, evidence: string}>, next_action: array{action: string}|null} $receipt */
    private static function hasCanonicalOutcome(array $receipt): bool
    {
        $allPassed = array_all($receipt['journeys'], static fn (array $journey): bool => $journey['status'] === 'passed');

        if ($receipt['result'] === 'passed') {
            return $receipt['next_action'] === null && $allPassed;
        }

        return in_array($receipt['result'], ['failed', 'unavailable', 'skipped', 'indeterminate'], true)
            && !$allPassed
            && is_array($receipt['next_action'])
            && array_keys($receipt['next_action']) === ['action']
            && is_string($receipt['next_action']['action'])
            && $receipt['next_action']['action'] !== '';
    }
}
