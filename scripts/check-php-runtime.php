<?php

declare(strict_types=1);

printf("PHP runtime: %s (%s)\n", PHP_VERSION, PHP_SAPI);

if (preg_match('/^8\.5\.\d+$/D', PHP_VERSION) !== 1 || PHP_VERSION_ID < 80512) {
    fwrite(STDERR, "FAIL: require stable PHP 8.5 >=8.5.12; rebuild the image and recreate its containers\n");
    exit(1);
}

if (ini_get('session.upload_progress.enabled') !== '0') {
    fwrite(STDERR, "FAIL: require session.upload_progress.enabled=0 in startup INI; rebuild the image and recreate its containers\n");
    exit(1);
}

printf("Runtime baseline OK; session.upload_progress.enabled=0\n");
