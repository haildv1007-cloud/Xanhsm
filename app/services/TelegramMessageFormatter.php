<?php

declare(strict_types=1);

final class TelegramMessageFormatter
{
    /** @param array<string, mixed> $lead */
    public static function build(array $lead, array $formConfig, ?string $citizenId): string
    {
        $escape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $copyable = static fn (mixed $value): string => '<code>' . $escape($value) . '</code>';
        $label = static fn (string $group, mixed $value): string => (string) ($formConfig['options'][$group][(string) $value] ?? $value);
        $participationLabels = [
            'company' => 'Chưa Có ( Chạy Xe Công Ty )',
            'platform' => 'Đã Có ( Platform )',
            'rto' => 'Chưa Có ( Thuê Xe Sở Hữu )',
        ];
        $vehicleLabels = [
            'electric-bike' => 'Xe Máy ( Xanh Bike )',
            'electric-car' => 'Ô Tô ( Xanh Taxi )',
            'van' => 'Xe Van ( Xanh Van )',
        ];
        $sourceUrl = (string) ($lead['source_url'] ?? '');
        if ($sourceUrl === '') {
            $baseUrl = rtrim((string) env('APP_URL', ''), '/');
            $route = match ((string) ($lead['source_page'] ?? '')) {
                'taxi' => '/taxi',
                'rto' => '/rto',
                'van' => '/van',
                default => '/',
            };
            $sourceUrl = $baseUrl !== '' ? $baseUrl . $route : $route;
        }

        return implode("\n", [
            '<b>Thông báo dữ liệu từ Xanh</b>',
            'Họ tên: ' . $copyable($lead['full_name']),
            'Số điện thoại: ' . $copyable($lead['phone']),
            'Khu vực: ' . $copyable($label('regions', $lead['region'])),
            'Số Zalo: ' . $copyable($lead['zalo'] ?: 'Không cung cấp'),
            'Hình thức: ' . $copyable($participationLabels[(string) $lead['cooperation_type']] ?? $label('cooperation_types', $lead['cooperation_type'])),
            'Phương tiện: ' . $copyable($vehicleLabels[(string) $lead['vehicle']] ?? $label('vehicles', $lead['vehicle'])),
            'Số CCCD: ' . $copyable($citizenId ?: 'Không cung cấp'),
            'Nguồn từ: ' . $copyable($sourceUrl),
        ]);
    }
}
