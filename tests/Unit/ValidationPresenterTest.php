<?php

namespace Tests\Unit;

use App\Support\ValidationPresenter;
use Illuminate\Support\MessageBag;
use PHPUnit\Framework\TestCase;

class ValidationPresenterTest extends TestCase
{
    public function test_it_groups_nested_password_rule_errors_under_password_field(): void
    {
        $errors = new MessageBag([
            'password' => ['فیلد رمز عبور الزامی است.'],
            'password.letters' => ['رمز عبور باید حداقل شامل یک حرف باشد.'],
            'password.numbers' => ['رمز عبور باید حداقل شامل یک عدد باشد.'],
            'password_confirmation' => ['مقدار تکرار رمز عبور با رمز عبور مطابقت ندارد.'],
        ]);

        $this->assertSame(
            [
                'فیلد رمز عبور الزامی است.',
                'رمز عبور باید حداقل شامل یک حرف باشد.',
                'رمز عبور باید حداقل شامل یک عدد باشد.',
            ],
            ValidationPresenter::messages($errors, 'password'),
        );

        $this->assertSame(
            ['مقدار تکرار رمز عبور با رمز عبور مطابقت ندارد.'],
            ValidationPresenter::messages($errors, 'password_confirmation'),
        );
    }
}
