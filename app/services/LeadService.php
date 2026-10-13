<?php

declare(strict_types=1);

final class LeadService
{
    public function __construct(
        private readonly PDO $database,
        private readonly array $formConfig,
    ) {
    }

    /** @return array{data: array<string, string>, errors: array<string, string>} */
    public function validate(array $input): array
    {
        $data = [];
        foreach (array_keys($this->formConfig['fields']) as $field) {
            $value = $input[$field] ?? '';
            $data[$field] = is_string($value) ? trim($value) : '';
        }

        $errors = [];
        foreach ($this->formConfig['fields'] as $field => $definition) {
            if (($definition['required'] ?? false) && $data[$field] === '') {
                $errors[$field] = 'Vui lòng nhập ' . mb_strtolower((string) $definition['label'], 'UTF-8') . '.';
            }
        }

        if ($data['full_name'] !== '' && (mb_strlen($data['full_name']) < 2 || mb_strlen($data['full_name']) > 100)) {
            $errors['full_name'] = 'Họ và tên cần có từ 2 đến 100 ký tự.';
        }

        $data['phone'] = $this->normalizePhone($data['phone']);
        if ($data['phone'] === '' || !preg_match('/^(?:\+84|0)[0-9]{9}$/', $data['phone'])) {
            $errors['phone'] = 'Vui lòng nhập số điện thoại Việt Nam hợp lệ.';
        }

        if ($data['zalo'] !== '') {
            $data['zalo'] = $this->normalizePhone($data['zalo']);
            if (!preg_match('/^(?:\+84|0)[0-9]{9}$/', $data['zalo'])) {
                $errors['zalo'] = 'Vui lòng nhập số Zalo hợp lệ.';
            }
        }

        if ($data['citizen_id'] !== '' && !preg_match('/^[0-9]{9,12}$/', $data['citizen_id'])) {
            $errors['citizen_id'] = 'Vui lòng nhập CCCD gồm 9 đến 12 chữ số.';
        }

        foreach (['region' => 'regions', 'vehicle' => 'vehicles', 'cooperation_type' => 'cooperation_types'] as $field => $optionGroup) {
            if ($data[$field] !== '' && !array_key_exists($data[$field], $this->formConfig['options'][$optionGroup])) {
                $errors[$field] = 'Lựa chọn không hợp lệ.';
            }
        }

        return ['data' => $data, 'errors' => $errors];
    }

    /** @return array{lead_id: int, public_id: string, duplicate: bool} */
    public function create(array $data, array $metadata): array
    {
        $token = (string) ($metadata['submission_token'] ?? '');
        if (!preg_match('/^[a-f0-9]{32,64}$/', $token)) {
            throw new InvalidArgumentException('Invalid submission token.');
        }

        $existing = $this->findByToken($token);
        if ($existing !== null) {
            return ['lead_id' => (int) $existing['id'], 'public_id' => (string) $existing['public_id'], 'duplicate' => true];
        }

        $publicId = 'XS-' . strtoupper(bin2hex(random_bytes(5)));
        $this->database->beginTransaction();

        try {
            $statement = $this->database->prepare(
                'INSERT INTO leads (public_id, submission_token, full_name, phone, zalo, citizen_id_encrypted, region, vehicle, cooperation_type, source_page, form_location, source_url, utm_source, utm_medium, utm_campaign, utm_content, utm_term, click_id, ip_hash, status, created_at, updated_at) '
                . 'VALUES (:public_id, :submission_token, :full_name, :phone, :zalo, :citizen_id, :region, :vehicle, :cooperation_type, :source_page, :form_location, :source_url, :utm_source, :utm_medium, :utm_campaign, :utm_content, :utm_term, :click_id, :ip_hash, :status, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)'
            );
            $statement->execute([
                'public_id' => $publicId,
                'submission_token' => $token,
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'zalo' => $data['zalo'] !== '' ? $data['zalo'] : null,
                'citizen_id' => Encryption::encrypt($data['citizen_id']),
                'region' => $data['region'],
                'vehicle' => $data['vehicle'],
                'cooperation_type' => $data['cooperation_type'],
                'source_page' => $metadata['source_page'],
                'form_location' => $metadata['form_location'],
                'source_url' => $metadata['source_url'],
                'utm_source' => $metadata['utm_source'],
                'utm_medium' => $metadata['utm_medium'],
                'utm_campaign' => $metadata['utm_campaign'],
                'utm_content' => $metadata['utm_content'],
                'utm_term' => $metadata['utm_term'],
                'click_id' => $metadata['click_id'],
                'ip_hash' => $metadata['ip_hash'],
                'status' => 'new',
            ]);

            $leadId = (int) $this->database->lastInsertId();
            $job = $this->database->prepare(
                "INSERT INTO telegram_jobs (lead_id, job_type, status, attempts, next_attempt_at, created_at, updated_at) VALUES (:lead_id, 'new_lead', 'pending', 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)"
            );
            $job->execute(['lead_id' => $leadId]);
            $this->database->commit();

            return ['lead_id' => $leadId, 'public_id' => $publicId, 'duplicate' => false];
        } catch (PDOException $exception) {
            if ($this->database->inTransaction()) {
                $this->database->rollBack();
            }
            $existing = $this->findByToken($token);
            if ($existing !== null) {
                return ['lead_id' => (int) $existing['id'], 'public_id' => (string) $existing['public_id'], 'duplicate' => true];
            }
            throw $exception;
        }
    }

    public function isRateLimited(string $ipHash): bool
    {
        $attempts = (int) ($this->formConfig['rate_limit']['attempts'] ?? 5);
        $minutes = (int) ($this->formConfig['rate_limit']['minutes'] ?? 10);
        $threshold = date('Y-m-d H:i:s', time() - ($minutes * 60));
        $statement = $this->database->prepare('SELECT COUNT(*) FROM leads WHERE ip_hash = :ip_hash AND created_at >= :threshold');
        $statement->execute(['ip_hash' => $ipHash, 'threshold' => $threshold]);
        return (int) $statement->fetchColumn() >= $attempts;
    }

    /** @return array{id: int|string, public_id: string}|null */
    public function findExisting(string $token): ?array
    {
        if (!preg_match('/^[a-f0-9]{32,64}$/', $token)) {
            return null;
        }
        return $this->findByToken($token);
    }

    private function findByToken(string $token): ?array
    {
        $statement = $this->database->prepare('SELECT id, public_id FROM leads WHERE submission_token = :token LIMIT 1');
        $statement->execute(['token' => $token]);
        $result = $statement->fetch();
        return is_array($result) ? $result : null;
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[\s.()-]+/', '', $phone) ?? '';
        if (str_starts_with($phone, '84') && !str_starts_with($phone, '+84')) {
            $phone = '+' . $phone;
        }
        return $phone;
    }
}
