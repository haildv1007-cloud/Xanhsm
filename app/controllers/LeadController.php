<?php

declare(strict_types=1);

require_once BASE_PATH . '/app/services/Database.php';
require_once BASE_PATH . '/app/services/Encryption.php';
require_once BASE_PATH . '/app/services/LeadService.php';

final class LeadController
{
    public static function store(array $formConfig): never
    {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-store');

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            header('Allow: POST');
            self::respond(405, ['ok' => false, 'message' => 'Phương thức không được hỗ trợ.']);
        }

        $contentType = (string) ($_SERVER['CONTENT_TYPE'] ?? '');
        $input = str_contains($contentType, 'application/json')
            ? json_decode((string) file_get_contents('php://input'), true)
            : $_POST;

        if (!is_array($input)) {
            self::respond(400, ['ok' => false, 'message' => 'Dữ liệu gửi lên không hợp lệ.']);
        }

        $csrf = is_string($input['csrf_token'] ?? null) ? $input['csrf_token'] : '';
        if ($csrf === '' || !hash_equals(csrf_token(), $csrf)) {
            self::respond(419, ['ok' => false, 'message' => 'Phiên đăng ký đã hết hạn. Vui lòng tải lại trang và thử lại.']);
        }

        if (trim((string) ($input['website'] ?? '')) !== '') {
            self::respond(200, ['ok' => true, 'message' => 'Đã tiếp nhận thông tin đăng ký.']);
        }

        $sourcePage = (string) ($input['source_page'] ?? '');
        if (!in_array($sourcePage, ['bike', 'taxi', 'rto', 'van'], true)) {
            $sourcePage = 'unknown';
        }
        $formLocation = in_array(($input['form_location'] ?? ''), ['inline', 'modal'], true)
            ? (string) $input['form_location']
            : 'unknown';

        $remoteAddress = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $hashKey = (string) env('APP_ENCRYPTION_KEY', 'local-development-key');
        $ipHash = hash_hmac('sha256', $remoteAddress, $hashKey);

        try {
            $service = new LeadService(Database::connection(), $formConfig);
            $validated = $service->validate($input);
            if ($validated['errors'] !== []) {
                self::respond(422, [
                    'ok' => false,
                    'message' => 'Vui lòng kiểm tra lại các trường được đánh dấu.',
                    'errors' => $validated['errors'],
                ]);
            }

            $submissionToken = trim((string) ($input['submission_token'] ?? ''));
            if (!preg_match('/^[a-f0-9]{32,64}$/', $submissionToken)) {
                self::respond(422, ['ok' => false, 'message' => 'Mã gửi không hợp lệ. Vui lòng tải lại trang và thử lại.']);
            }

            $existing = $service->findExisting($submissionToken);
            if ($existing !== null) {
                self::respond(200, [
                    'ok' => true,
                    'message' => 'Thông tin này đã được tiếp nhận trước đó.',
                    'reference' => (string) $existing['public_id'],
                    'duplicate' => true,
                ]);
            }

            if ($service->isRateLimited($ipHash)) {
                self::respond(429, ['ok' => false, 'message' => 'Bạn đã gửi nhiều lần. Vui lòng thử lại sau ít phút.']);
            }

            $metadata = [
                'submission_token' => $submissionToken,
                'source_page' => $sourcePage,
                'form_location' => $formLocation,
                'source_url' => self::sourceUrl($input['source_url'] ?? ''),
                'utm_source' => self::limited($input['utm_source'] ?? ''),
                'utm_medium' => self::limited($input['utm_medium'] ?? ''),
                'utm_campaign' => self::limited($input['utm_campaign'] ?? ''),
                'utm_content' => self::limited($input['utm_content'] ?? ''),
                'utm_term' => self::limited($input['utm_term'] ?? ''),
                'click_id' => self::limited($input['click_id'] ?? ''),
                'ip_hash' => $ipHash,
            ];

            try {
                $result = $service->create($validated['data'], $metadata);
            } catch (InvalidArgumentException) {
                self::respond(422, ['ok' => false, 'message' => 'Mã gửi không hợp lệ. Vui lòng tải lại trang và thử lại.']);
            }

            self::respond(201, [
                'ok' => true,
                'message' => 'Đã nhận thông tin. Tư vấn viên sẽ liên hệ với bạn trong thời gian sớm nhất.',
                'reference' => $result['public_id'],
                'duplicate' => $result['duplicate'],
            ]);
        } catch (Throwable $exception) {
            error_log('Lead submission failed: ' . $exception::class);
            self::respond(503, [
                'ok' => false,
                'message' => 'Hệ thống đang tạm gián đoạn. Thông tin của bạn vẫn còn trên biểu mẫu, vui lòng thử lại sau.',
            ]);
        }
    }

    private static function limited(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }
        $value = trim($value);
        return $value === '' ? null : mb_substr($value, 0, 255);
    }

    private static function sourceUrl(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }
        $value = trim($value);
        if ($value === '' || filter_var($value, FILTER_VALIDATE_URL) === false) {
            return null;
        }
        $scheme = strtolower((string) parse_url($value, PHP_URL_SCHEME));
        if (!in_array($scheme, ['http', 'https'], true)) {
            return null;
        }

        $sourceHost = strtolower((string) parse_url($value, PHP_URL_HOST));
        $appHost = strtolower((string) parse_url((string) env('APP_URL', ''), PHP_URL_HOST));
        $requestHost = strtolower(preg_replace('/:\d+$/', '', (string) ($_SERVER['HTTP_HOST'] ?? '')) ?? '');
        $allowedHost = $appHost !== '' ? $appHost : $requestHost;
        if ($sourceHost === '' || $allowedHost === '' || !hash_equals($allowedHost, $sourceHost)) {
            return null;
        }

        return mb_substr($value, 0, 2048);
    }

    private static function respond(int $status, array $payload): never
    {
        http_response_code($status);
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
