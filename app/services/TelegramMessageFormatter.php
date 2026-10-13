<?php

declare(strict_types=1);

final class TelegramMessageFormatter
{
    /** @param array<string, mixed> $lead */
    public static function build(array $lead, array $formConfig, ?string $citizenId): string
    {
        $escape = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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
            'Thông báo dữ liệu từ Xanh',
            'name : ' . $escape($lead['full_name']),
            'phone : ' . $escape($lead['phone']),
            'Khu Vực : ' . $escape($label('regions', $lead['region'])),
            'Số Điện Thoại Zalo Liên Hệ : ' . $escape($lead['zalo'] ?: 'Không cung cấp'),
            'Bạn Đã Có Xe Vinfast? : ' . $escape($participationLabels[(string) $lead['cooperation_type']] ?? $label('cooperation_types', $lead['cooperation_type'])),
            'Phương Tiện : ' . $escape($vehicleLabels[(string) $lead['vehicle']] ?? $label('vehicles', $lead['vehicle'])),
            'Số CCCD Của Bạn : ' . $escape($citizenId ?: 'Không cung cấp'),
            'Nguồn từ: ' . $escape($sourceUrl),
        ]);
    }
}
