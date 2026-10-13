<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/bootstrap.php';
require BASE_PATH . '/app/services/Database.php';
require BASE_PATH . '/app/services/Encryption.php';
require BASE_PATH . '/app/services/TelegramService.php';
require BASE_PATH . '/app/services/TelegramMessageFormatter.php';

$isCli = PHP_SAPI === 'cli';
function workerOutput(string $message, bool $error = false): void
{
    if (PHP_SAPI === 'cli') {
        fwrite($error ? STDERR : STDOUT, $message);
        return;
    }
    echo $message;
}

if (!$isCli) {
    header('Content-Type: text/plain; charset=UTF-8');
    header('Cache-Control: no-store');
    if (!in_array(($_SERVER['REQUEST_METHOD'] ?? 'GET'), ['GET', 'POST'], true)) {
        http_response_code(405);
        exit("Method not allowed.\n");
    }

    $configuredSecret = (string) env('CRON_SECRET', '');
    $providedSecret = (string) ($_SERVER['HTTP_X_CRON_SECRET'] ?? ($_GET['token'] ?? ''));
    if ($configuredSecret === '' || $providedSecret === '' || !hash_equals($configuredSecret, $providedSecret)) {
        http_response_code(403);
        exit("Forbidden.\n");
    }
}

if (env('TELEGRAM_ENABLED', false) !== true) {
    workerOutput("Telegram delivery is disabled.\n");
    exit(0);
}

$database = Database::connection();
$lock = $database->query("SELECT GET_LOCK('xanhsm_telegram_cron', 0)")->fetchColumn();
if ((int) $lock !== 1) {
    workerOutput("Another Telegram worker is running.\n");
    exit(0);
}

$maxAttempts = max(1, (int) env('TELEGRAM_MAX_ATTEMPTS', 5));
$formConfig = require BASE_PATH . '/config/forms.php';
$telegram = new TelegramService((string) env('TELEGRAM_BOT_TOKEN', ''), (string) env('TELEGRAM_CHAT_ID', ''));

try {
    $database->exec("UPDATE telegram_jobs SET status = 'retry', locked_at = NULL, next_attempt_at = CURRENT_TIMESTAMP, updated_at = CURRENT_TIMESTAMP WHERE status = 'processing' AND locked_at < (CURRENT_TIMESTAMP - INTERVAL 10 MINUTE)");

    while (true) {
        $database->beginTransaction();
        $statement = $database->query(
            "SELECT j.id AS job_id, j.attempts, l.* FROM telegram_jobs j JOIN leads l ON l.id = j.lead_id "
            . "WHERE j.status IN ('pending', 'retry') AND j.next_attempt_at <= CURRENT_TIMESTAMP "
            . "ORDER BY j.id ASC LIMIT 1 FOR UPDATE"
        );
        $job = $statement->fetch();

        if (!is_array($job)) {
            $database->commit();
            break;
        }

        $claim = $database->prepare("UPDATE telegram_jobs SET status = 'processing', locked_at = CURRENT_TIMESTAMP, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        $claim->execute(['id' => $job['job_id']]);
        $database->commit();

        try {
            $citizenId = Encryption::decrypt($job['citizen_id_encrypted'] ?? null);
            $result = $telegram->send(TelegramMessageFormatter::build($job, $formConfig, $citizenId));
            $sent = $database->prepare("UPDATE telegram_jobs SET status = 'sent', attempts = attempts + 1, sent_at = CURRENT_TIMESTAMP, locked_at = NULL, telegram_message_id = :message_id, last_error = NULL, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
            $sent->execute(['message_id' => $result['message_id'], 'id' => $job['job_id']]);
            workerOutput('Sent lead ' . $job['public_id'] . PHP_EOL);
        } catch (Throwable $exception) {
            $attempt = (int) $job['attempts'] + 1;
            $status = $attempt >= $maxAttempts ? 'failed' : 'retry';
            $delayMinutes = min(60, 2 ** min($attempt, 5));
            $nextAttempt = date('Y-m-d H:i:s', time() + ($delayMinutes * 60));
            $failed = $database->prepare("UPDATE telegram_jobs SET status = :status, attempts = :attempts, next_attempt_at = :next_attempt_at, locked_at = NULL, last_error = :last_error, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
            $failed->execute([
                'status' => $status,
                'attempts' => $attempt,
                'next_attempt_at' => $nextAttempt,
                'last_error' => mb_substr($exception->getMessage(), 0, 255),
                'id' => $job['job_id'],
            ]);
            workerOutput('Telegram job ' . $job['job_id'] . ' ' . $status . PHP_EOL, true);
        }
    }
} finally {
    $database->query("SELECT RELEASE_LOCK('xanhsm_telegram_cron')");
}

