<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$candidateRoot = $argv[1] ?? '';
$authorityFile = $candidateRoot.'/release/src/Application/StarterSupportReceiptAuthority.php';
if ($candidateRoot === '' || !is_file($authorityFile)) {
    fwrite(STDERR, "Fight Common receipt authority is missing from the exact detached candidate checkout.\n");
    exit(1);
}

$reference = trim((string) shell_exec(sprintf('git -C %s rev-parse HEAD', escapeshellarg($candidateRoot))));
if ($reference !== '4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16') {
    fwrite(STDERR, "Fight Common receipt authority checkout is not the exact candidate.\n");
    exit(1);
}

require $projectRoot.'/scripts/framework-support-receipt.php';
require $authorityFile;

$receiptPath = $projectRoot.'/evidence/framework-support/receipt-v1.json';
$receipt = json_decode((string) file_get_contents($receiptPath), true, flags: JSON_THROW_ON_ERROR);
$authority = new Fight\Release\Application\StarterSupportReceiptAuthority();

if (!$authority->isValid($receipt)) {
    fwrite(STDERR, "Fight Common StarterSupportReceiptAuthority rejected the committed receipt.\n");
    exit(1);
}

if (!hash_equals(frameworkSupportCanonicalJson(frameworkSupportReceipt($projectRoot)), (string) file_get_contents($receiptPath))) {
    fwrite(STDERR, "The committed receipt bytes do not match the current latest lock evidence.\n");
    exit(1);
}
