<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require dirname(__DIR__) . '/app/bootstrap.php';
require BASE_PATH . '/app/services/Database.php';

$files = glob(BASE_PATH . '/database/migrations/*.sql') ?: [];
sort($files);

if ($files === []) {
    fwrite(STDERR, "No migrations found.\n");
    exit(1);
}

try {
    $database = Database::connection();
    foreach ($files as $file) {
        $sql = file_get_contents($file);
        if ($sql === false) {
            throw new RuntimeException('Unable to read migration: ' . basename($file));
        }
        $database->exec($sql);
        fwrite(STDOUT, 'Applied ' . basename($file) . PHP_EOL);
    }
} catch (Throwable $exception) {
    fwrite(STDERR, 'Migration failed: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
