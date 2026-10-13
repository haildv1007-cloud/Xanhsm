<?php

declare(strict_types=1);

// Read-only local smoke checks. Start the PHP development server first.
if (PHP_SAPI !== 'cli') {
    exit(1);
}

$base = rtrim($argv[1] ?? 'http://127.0.0.1:8080', '/');
$failures = [];
$pages = [];
function check(bool $condition, string $message): void
{
    global $failures;
    if (!$condition) {
        $failures[] = $message;
    }
}

foreach (['/' => 200, '/taxi' => 200, '/rto' => 200, '/van' => 200, '/dang-ky-thanh-cong' => 200, '/not-a-page' => 404] as $route => $expected) {
    $context = stream_context_create(['http' => ['ignore_errors' => true, 'timeout' => 5]]);
    $html = file_get_contents($base . $route, false, $context);
    check($html !== false, "$route responds");
    check(str_contains($http_response_header[0] ?? '', (string) $expected), "$route status $expected");
    if ($html === false) {
        continue;
    }
    check(!preg_match('/Fatal error|Warning:|Parse error/', $html), "$route has no PHP error");
    preg_match_all('/\bid="([^"]+)"/', $html, $ids);
    check(count($ids[1]) === count(array_unique($ids[1])), "$route has unique IDs");
    preg_match_all('/href="#([^"]+)"/', $html, $anchors);
    foreach ($anchors[1] as $anchor) {
        check(in_array($anchor, $ids[1], true), "$route anchor #$anchor exists");
    }
    if ($expected === 200) {
        check(substr_count($html, 'id="registration-modal"') === 1, "$route has one shared form modal");
        check(substr_count($html, 'id="success-modal"') === 1, "$route has one shared success modal");
        check(str_contains($html, 'Trang web được tạo lên bởi đơn vị liên kết tuyển dụng tài xế Xanh SM'), "$route footer text");
    }
    $pages[$route] = $html;
    echo "$route: HTTP $expected checked\n";
}

$success = $pages['/dang-ky-thanh-cong'] ?? '';
check(str_contains($success, 'data-auto-open'), 'Success route auto-opens the confirmation dialog');
check(str_contains($success, '<meta name="robots" content="noindex,follow">'), 'Success route is not indexed');
check(str_contains($success, '<link rel="canonical" href="http'), 'Success route has a canonical URL when base URL is available');
check(!str_contains($success, '<loc>' . $base . '/dang-ky-thanh-cong</loc>'), 'Success route is not added to the sitemap');

$taxi = $pages['/taxi'] ?? '';
check(substr_count($taxi, 'data-registration-form') === 2, 'Taxi has inline and modal forms');
check(!str_contains($taxi, 'id="participation-modal"'), 'Taxi has no Bike participation modal');
check(str_contains($taxi, 'fetchpriority="high"'), 'Taxi hero has high fetch priority');
$last = -1;
foreach (['bike-hero taxi-hero', 'countdown-strip', 'registration-section', 'benefits section', 'documents section', 'process section', 'stories section', 'faq section', 'site-footer'] as $section) {
    $position = strpos($taxi, 'class="' . $section . '"');
    check($position !== false && $position > $last, 'Taxi section order: ' . $section);
    $last = $position === false ? $last : $position;
}
preg_match_all('/data-image="([^"]+)"/', $taxi, $taxiStories);
preg_match_all('/data-image="([^"]+)"/', $pages['/'] ?? '', $bikeStories);
check(count($taxiStories[1]) === 3 && $taxiStories[1] === $bikeStories[1], 'Taxi uses the same three Bike gallery images');
preg_match_all('/<img[^>]+src="([^"]+)"/', $taxi, $images);
foreach ($images[1] as $image) {
    $path = parse_url(html_entity_decode($image), PHP_URL_PATH);
    check(is_string($path) && is_file(dirname(__DIR__) . '/public' . $path), 'Taxi image exists: ' . $image);
}

$rto = $pages['/rto'] ?? '';
check(substr_count($rto, 'data-registration-form') === 2, 'RTO has inline and modal forms');
check(!str_contains($rto, 'id="participation-modal"'), 'RTO has no Bike participation modal');
check(str_contains($rto, 'assets/images/hero-section/rto.webp'), 'RTO uses its supplied hero');
check(str_contains($rto, 'width="1680" height="945"'), 'RTO hero declares intrinsic dimensions');
check(str_contains($rto, 'fetchpriority="high"'), 'RTO hero has high fetch priority');
check(substr_count($rto, 'value="rto" selected') === 2, 'RTO is preselected in both forms');
preg_match_all('/<select[^>]+name="vehicle"[^>]*>([\s\S]*?)<\/select>/', $rto, $rtoVehicleSelects);
check(count($rtoVehicleSelects[1]) === 2 && !array_filter($rtoVehicleSelects[1], static fn (string $select): bool => str_contains($select, 'selected')), 'RTO does not preselect a vehicle');
check(str_contains($rto, 'href="/rto" aria-current="page"'), 'RTO mobile navigation is active');
$last = -1;
foreach (['bike-hero rto-hero', 'countdown-strip', 'registration-section', 'rto-intro section', 'benefits section', 'documents section', 'process section', 'stories section', 'faq section', 'site-footer'] as $section) {
    $position = strpos($rto, 'class="' . $section . '"');
    check($position !== false && $position > $last, 'RTO section order: ' . $section);
    $last = $position === false ? $last : $position;
}
check(!str_contains($rto, 'Trao đổi trước khi tham gia'), 'RTO omits the redundant policy section');
check(!str_contains($rto, 'Bắt đầu như thế nào?'), 'RTO intro omits the redundant start block');
preg_match_all('/data-image="([^"]+)"/', $rto, $rtoStories);
check(count($rtoStories[1]) === 3 && $rtoStories[1] === $bikeStories[1], 'RTO uses the same three Bike gallery images');
preg_match_all('/<img[^>]+src="([^"]+)"/', $rto, $rtoImages);
foreach ($rtoImages[1] as $image) {
    $path = parse_url(html_entity_decode($image), PHP_URL_PATH);
    check(is_string($path) && is_file(dirname(__DIR__) . '/public' . $path), 'RTO image exists: ' . $image);
}

if ($failures !== []) {
    fwrite(STDERR, implode("\n", $failures) . "\n");
    exit(1);
}
echo "PASS: routes, IDs, anchors, shared modals, success route, Taxi/RTO sections, defaults, hero and gallery assets.\n";
