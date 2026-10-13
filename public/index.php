<?php

declare(strict_types=1);

if (PHP_SAPI === 'cli-server') {
    $requestedFile = __DIR__ . parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if (is_file($requestedFile)) {
        return false;
    }
}

require dirname(__DIR__) . '/app/bootstrap.php';

$site = require BASE_PATH . '/config/site.php';
$form = require BASE_PATH . '/config/forms.php';
$routes = require BASE_PATH . '/app/routes.php';

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestPath = is_string($requestPath) ? rawurldecode($requestPath) : '/';
$requestPath = $requestPath !== '/' ? rtrim($requestPath, '/') : '/';

$requestScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$requestHost = (string) ($_SERVER['HTTP_HOST'] ?? '');
$baseUrl = rtrim((string) ($site['url'] ?? ''), '/');
if ($baseUrl === '' && preg_match('/^[A-Za-z0-9.-]+(?::[0-9]+)?$/', $requestHost)) {
    $baseUrl = $requestScheme . '://' . $requestHost;
}

if ($requestPath === '/robots.txt') {
    header('Content-Type: text/plain; charset=UTF-8');
    header('Cache-Control: public, max-age=3600');
    echo "User-agent: *\nAllow: /\nDisallow: /api/\nDisallow: /cron/\n";
    if ($baseUrl !== '') {
        echo 'Sitemap: ' . $baseUrl . "/sitemap.xml\n";
    }
    exit;
}

if ($requestPath === '/sitemap.xml') {
    header('Content-Type: application/xml; charset=UTF-8');
    header('Cache-Control: public, max-age=3600');
    $xmlEscape = static fn (string $value): string => htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    foreach (array_keys($routes) as $route) {
        $location = $baseUrl . ($route === '/' ? '/' : $route);
        echo '  <url><loc>' . $xmlEscape($location) . "</loc></url>\n";
    }
    echo "</urlset>\n";
    exit;
}

if ($requestPath === '/api/leads') {
    require BASE_PATH . '/app/controllers/LeadController.php';
    LeadController::store($form);
}

if ($requestPath === '/cron/send-telegram') {
    require BASE_PATH . '/cron/send-telegram.php';
    exit;
}

$navigation = [];
foreach ($routes as $route => $slug) {
    $navigation[] = require BASE_PATH . '/content/' . $slug . '.php';
}

$successPath = (string) ($site['success_path'] ?? '/dang-ky-thanh-cong');
if ($requestPath === $successPath) {
    $currentRoute = '';
    $page = require BASE_PATH . '/content/bike.php';
    $page['route'] = $successPath;
    $page['seo'] = [
        'title' => 'Đăng ký thành công',
        'description' => 'Thông tin đăng ký đã được tiếp nhận.',
        'robots' => 'noindex,follow',
        'canonical_route' => '/',
    ];
    $submissionToken = bin2hex(random_bytes(16));
    $showSuccessModal = true;
    $contentView = BASE_PATH . '/app/views/pages/bike.php';
    require BASE_PATH . '/app/views/layouts/app.php';
    exit;
}

if (!isset($routes[$requestPath])) {
    http_response_code(404);
    $page = [
        'slug' => 'not-found',
        'seo' => [
            'title' => 'Không tìm thấy trang',
            'description' => 'Trang bạn yêu cầu không tồn tại.',
        ],
    ];
    $currentRoute = '';
    $contentView = BASE_PATH . '/app/views/pages/404.php';
    require BASE_PATH . '/app/views/layouts/app.php';
    exit;
}

$currentRoute = $requestPath;
$page = require BASE_PATH . '/content/' . $routes[$requestPath] . '.php';
$submissionToken = bin2hex(random_bytes(16));
$contentView = BASE_PATH . '/app/views/pages/' . (in_array($page['slug'], ['bike', 'taxi', 'rto', 'van'], true) ? $page['slug'] : 'landing') . '.php';

require BASE_PATH . '/app/views/layouts/app.php';
