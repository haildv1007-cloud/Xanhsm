<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit(1);
}

putenv('APP_ENCRYPTION_KEY=' . base64_encode(str_repeat('k', 32)));
require dirname(__DIR__) . '/app/bootstrap.php';
require BASE_PATH . '/app/services/Database.php';
require BASE_PATH . '/app/services/Encryption.php';
require BASE_PATH . '/app/services/LeadService.php';
require BASE_PATH . '/app/services/TelegramMessageFormatter.php';

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
        exit(1);
    }
    fwrite(STDOUT, 'PASS: ' . $message . PHP_EOL);
}

$testDatabasePath = getenv('TEST_SQLITE_PATH');
if (is_string($testDatabasePath) && $testDatabasePath !== '') {
    if (is_file($testDatabasePath)) {
        unlink($testDatabasePath);
    }
    $database = new PDO('sqlite:' . $testDatabasePath, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} else {
    $database = new PDO('sqlite::memory:', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}
$database->exec('CREATE TABLE leads (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    public_id TEXT NOT NULL UNIQUE,
    submission_token TEXT NOT NULL UNIQUE,
    full_name TEXT NOT NULL,
    phone TEXT NOT NULL,
    zalo TEXT NULL,
    citizen_id_encrypted TEXT NULL,
    region TEXT NOT NULL,
    vehicle TEXT NOT NULL,
    cooperation_type TEXT NOT NULL,
    source_page TEXT NOT NULL,
    form_location TEXT NOT NULL,
    source_url TEXT NULL,
    utm_source TEXT NULL,
    utm_medium TEXT NULL,
    utm_campaign TEXT NULL,
    utm_content TEXT NULL,
    utm_term TEXT NULL,
    click_id TEXT NULL,
    ip_hash TEXT NOT NULL,
    status TEXT NOT NULL,
    created_at TEXT NOT NULL,
    updated_at TEXT NOT NULL
)');
$database->exec('CREATE TABLE telegram_jobs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lead_id INTEGER NOT NULL,
    job_type TEXT NOT NULL,
    status TEXT NOT NULL,
    attempts INTEGER NOT NULL,
    next_attempt_at TEXT NOT NULL,
    created_at TEXT NOT NULL,
    updated_at TEXT NOT NULL,
    UNIQUE (lead_id, job_type)
)');

$config = require BASE_PATH . '/config/forms.php';
$service = new LeadService($database, $config);
$input = [
    'full_name' => 'Nguyễn Văn An',
    'phone' => '0912 345 678',
    'zalo' => '',
    'citizen_id' => '012345678901',
    'region' => 'ha-noi',
    'vehicle' => 'electric-bike',
    'cooperation_type' => 'company',
];
$validated = $service->validate($input);
assertTrue($validated['errors'] === [], 'dữ liệu hợp lệ được chấp nhận');
assertTrue($validated['data']['phone'] === '0912345678', 'số điện thoại được chuẩn hóa');

$metadata = [
    'submission_token' => str_repeat('a', 32),
    'source_page' => 'bike',
    'form_location' => 'inline',
    'source_url' => 'https://example.test/?gclid=test-click-id',
    'utm_source' => 'test',
    'utm_medium' => null,
    'utm_campaign' => null,
    'utm_content' => null,
    'utm_term' => null,
    'click_id' => null,
    'ip_hash' => hash('sha256', '127.0.0.1'),
];
$created = $service->create($validated['data'], $metadata);
assertTrue($created['duplicate'] === false, 'lần gửi đầu tạo hồ sơ mới');
assertTrue((int) $database->query('SELECT COUNT(*) FROM leads')->fetchColumn() === 1, 'tạo đúng một lead');
assertTrue((int) $database->query('SELECT COUNT(*) FROM telegram_jobs')->fetchColumn() === 1, 'tạo đúng một Telegram job trong cùng giao dịch');

$encrypted = (string) $database->query('SELECT citizen_id_encrypted FROM leads')->fetchColumn();
assertTrue($encrypted !== $input['citizen_id'], 'CCCD không được lưu dạng rõ');
assertTrue(Encryption::decrypt($encrypted) === $input['citizen_id'], 'CCCD mã hóa có thể giải mã bằng khóa ứng dụng');

$duplicate = $service->create($validated['data'], $metadata);
assertTrue($duplicate['duplicate'] === true, 'gửi lại cùng submission token trả kết quả cũ');
assertTrue((int) $database->query('SELECT COUNT(*) FROM leads')->fetchColumn() === 1, 'gửi lặp không tạo lead thứ hai');
assertTrue((int) $database->query('SELECT COUNT(*) FROM telegram_jobs')->fetchColumn() === 1, 'gửi lặp không tạo job Telegram thứ hai');

$invalid = $service->validate(array_merge($input, ['phone' => '123', 'region' => 'khong-hop-le']));
assertTrue(isset($invalid['errors']['phone'], $invalid['errors']['region']), 'số điện thoại và tỉnh thành sai bị từ chối');

$optional = $service->validate(array_merge($input, ['zalo' => '', 'citizen_id' => '']));
assertTrue(!isset($optional['errors']['zalo'], $optional['errors']['citizen_id']), 'Zalo và CCCD để trống vẫn hợp lệ');

$message = TelegramMessageFormatter::build([
    'full_name' => 'Người Kiểm Thử',
    'phone' => '0900000000',
    'zalo' => '0900000001',
    'region' => 'dong-nai',
    'vehicle' => 'electric-bike',
    'cooperation_type' => 'company',
    'source_page' => 'bike',
    'source_url' => 'https://example.test/?gclid=test&campaign=sample',
], $config, '000000000000');
assertTrue(str_starts_with($message, 'Thông báo dữ liệu từ Xanh'), 'thông báo Telegram có đúng tiêu đề');
assertTrue(str_contains($message, 'Khu Vực : Đồng Nai'), 'thông báo Telegram hiển thị nhãn khu vực');
assertTrue(str_contains($message, 'Bạn Đã Có Xe Vinfast? : Chưa Có ( Chạy Xe Công Ty )'), 'thông báo Telegram ánh xạ loại hình theo mẫu');
assertTrue(str_contains($message, 'Phương Tiện : Xe Máy ( Xanh Bike )'), 'thông báo Telegram ánh xạ phương tiện theo mẫu');
assertTrue(str_contains($message, 'Số CCCD Của Bạn : 000000000000'), 'thông báo Telegram có trường CCCD theo mẫu');
assertTrue(str_contains($message, 'Nguồn từ: https://example.test/?gclid=test&amp;campaign=sample'), 'nguồn đăng ký được escape an toàn cho Telegram HTML');

fwrite(STDOUT, "Lead service tests completed.\n");
