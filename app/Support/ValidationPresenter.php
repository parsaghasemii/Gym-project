<?php

namespace App\Support;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class ValidationPresenter
{
    /**
     * @return list<string>
     */
    public static function messages(ViewErrorBag|MessageBag $errors, string $field): array
    {
        return collect(self::bag($errors)->getMessages())
            ->filter(fn (array $messages, string $key) => self::matchesField($key, $field))
            ->flatten()
            ->values()
            ->all();
    }

    public static function hasError(ViewErrorBag|MessageBag $errors, string $field): bool
    {
        return collect(self::bag($errors)->getMessages())
            ->keys()
            ->contains(fn (string $key) => self::matchesField($key, $field));
    }

    private static function bag(ViewErrorBag|MessageBag $errors): MessageBag
    {
        return $errors instanceof ViewErrorBag ? $errors->getBag('default') : $errors;
    }

    private static function matchesField(string $key, string $field): bool
    {
        if ($field === 'password' && str_starts_with($key, 'password_')) {
            return false;
        }

        return $key === $field || str_starts_with($key, $field.'.');
    }
}
