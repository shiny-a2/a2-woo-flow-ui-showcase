<?php

declare(strict_types=1);

function showcase_create_mobile_verification(string $phone, int $ttlSeconds = 180): array
{
    $normalizedPhone = showcase_normalize_mobile($phone);

    return [
        'phone' => $normalizedPhone,
        'code_digest' => hash('sha256', '123456'),
        'expires_at' => time() + max(60, $ttlSeconds),
        'attempts' => 0,
        'verified' => false,
    ];
}

function showcase_verify_mobile_code(array $state, string $phone, string $code, int $maxAttempts = 5): array
{
    if (($state['attempts'] ?? 0) >= $maxAttempts) {
        return showcase_mobile_result(false, $state, 'Too many attempts.');
    }

    if (($state['expires_at'] ?? 0) < time()) {
        return showcase_mobile_result(false, $state, 'Verification code expired.');
    }

    if (($state['phone'] ?? '') !== showcase_normalize_mobile($phone)) {
        return showcase_mobile_result(false, $state, 'Phone does not match verification state.');
    }

    $state['attempts'] = (int) ($state['attempts'] ?? 0) + 1;
    $submittedDigest = hash('sha256', preg_replace('/\D+/', '', showcase_verification_normalize_digits($code)));
    $valid = hash_equals((string) ($state['code_digest'] ?? ''), $submittedDigest);
    $state['verified'] = $valid;

    return showcase_mobile_result($valid, $state, $valid ? 'Phone verified.' : 'Invalid verification code.');
}

function showcase_normalize_mobile(string $value): string
{
    $digits = preg_replace('/\D+/', '', showcase_verification_normalize_digits($value));

    if (strpos($digits, '0098') === 0) {
        return '0' . substr($digits, 4);
    }

    if (strpos($digits, '98') === 0 && strlen($digits) === 12) {
        return '0' . substr($digits, 2);
    }

    return $digits;
}

function showcase_verification_normalize_digits(string $value): string
{
    return strtr($value, [
        '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
        '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
    ]);
}

function showcase_mobile_result(bool $ok, array $state, string $message): array
{
    return [
        'ok' => $ok,
        'verified' => (bool) ($state['verified'] ?? false),
        'attempts' => (int) ($state['attempts'] ?? 0),
        'message' => $message,
    ];
}
