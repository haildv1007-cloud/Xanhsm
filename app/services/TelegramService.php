<?php

declare(strict_types=1);

final class TelegramService
{
    public function __construct(
        private readonly string $botToken,
        private readonly string $chatId,
    ) {
        if ($this->botToken === '' || $this->chatId === '') {
            throw new RuntimeException('Telegram bot token or group chat ID is missing.');
        }
        if (!preg_match('/^[0-9]+:[A-Za-z0-9_-]+$/', $this->botToken)) {
            throw new RuntimeException('Telegram bot token has an invalid format.');
        }
    }

    /** @return array{message_id: string} */
    public function send(string $message): array
    {
        $handle = curl_init('https://api.telegram.org/bot' . $this->botToken . '/sendMessage');
        if ($handle === false) {
            throw new RuntimeException('Unable to initialize Telegram request.');
        }

        curl_setopt_array($handle, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => 'true',
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ]);

        $body = curl_exec($handle);
        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        $error = curl_error($handle);
        curl_close($handle);

        if ($body === false || $error !== '') {
            throw new RuntimeException('Telegram network error.');
        }

        $decoded = json_decode($body, true);
        if ($status !== 200 || !is_array($decoded) || ($decoded['ok'] ?? false) !== true) {
            $description = is_array($decoded) ? (string) ($decoded['description'] ?? '') : '';
            throw new RuntimeException('Telegram API rejected the message' . ($description !== '' ? ': ' . $description : '.'));
        }

        return ['message_id' => (string) ($decoded['result']['message_id'] ?? '')];
    }
}
