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
            '<b>Thông báo dữ liệu từ Xanh</b>',
            'Họ tên: ' . $escape($lead['full_name']),
            'Số điện thoại: ' . $escape($lead['phone']),
            'Khu vực: ' . $escape($label('regions', $lead['region'])),
            'Số Zalo: ' . $escape($lead['zalo'] ?: 'Không cung cấp'),
            'Hình thức: ' . $escape($participationLabels[(string) $lead['cooperation_type']] ?? $label('cooperation_types', $lead['cooperation_type'])),
            'Phương tiện: ' . $escape($vehicleLabels[(string) $lead['vehicle']] ?? $label('vehicles', $lead['vehicle'])),
            'Số CCCD: ' . $escape($citizenId ?: 'Không cung cấp'),
            'Nguồn từ: ' . $escape($sourceUrl),
        ]);
    }

    /**
     * @param array<string, mixed> $lead
     * @return array{inline_keyboard: list<list<array{text: string, copy_text: array{text: string}}>>}
     */
    public static function copyKeyboard(array $lead, ?string $citizenId): array
    {
        $copyButton = static fn (string $label, mixed $value): array => [
            'text' => '📋 ' . $label,
            'copy_text' => ['text' => (string) ($value ?: 'Không cung cấp')],
        ];

        return [
            'inline_keyboard' => [
                [
                    $copyButton('Họ tên', $lead['full_name'] ?? ''),
                    $copyButton('SĐT', $lead['phone'] ?? ''),
                ],
                [
                    $copyButton('Zalo', $lead['zalo'] ?? ''),
                    $copyButton('CCCD', $citizenId),
                ],
            ],
        ];
    }
}
