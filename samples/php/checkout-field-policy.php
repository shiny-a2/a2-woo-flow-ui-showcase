<?php

declare(strict_types=1);

function showcase_validate_checkout_fields(array $input, array $policy): array
{
    $errors = [];

    foreach (showcase_checkout_field_rules($policy) as $field => $rule) {
        $value = showcase_normalize_digits((string) ($input[$field] ?? ''));

        if (($rule['required'] ?? false) && trim($value) === '') {
            $errors[$field][] = 'This field is required.';
            continue;
        }

        if ($value !== '' && isset($rule['validator']) && !$rule['validator']($value)) {
            $errors[$field][] = $rule['message'];
        }
    }

    return [
        'valid' => $errors === [],
        'errors' => $errors,
    ];
}

function showcase_checkout_field_rules(array $policy): array
{
    return [
        'phone' => [
            'required' => $policy['require_phone'] ?? true,
            'validator' => 'showcase_is_mobile_number',
            'message' => 'Phone must use a valid mobile format.',
        ],
        'postcode' => [
            'required' => $policy['require_postcode'] ?? false,
            'validator' => 'showcase_is_postcode',
            'message' => 'Postcode must be ten non-repeating digits.',
        ],
        'terms' => [
            'required' => true,
            'validator' => static fn ($value): bool => $value === 'yes',
            'message' => 'Terms must be accepted before checkout.',
        ],
    ];
}

function showcase_normalize_digits(string $value): string
{
    return strtr($value, [
        '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
        '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
        '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
        '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
    ]);
}

function showcase_is_mobile_number(string $value): bool
{
    $digits = preg_replace('/\D+/', '', showcase_normalize_digits($value));

    return (bool) preg_match('/^09\d{9}$/', $digits);
}

function showcase_is_postcode(string $value): bool
{
    $digits = preg_replace('/\D+/', '', showcase_normalize_digits($value));

    return strlen($digits) === 10 && !preg_match('/^(\d)\1{9}$/', $digits);
}
