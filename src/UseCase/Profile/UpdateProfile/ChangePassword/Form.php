<?php

namespace App\UseCase\Profile\UpdateProfile\ChangePassword;

use App\Domain\User\User;
use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Callback;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\ValidationContext;

#[Callback(method: 'validatePassword')]
final class Form extends FormModel
{
    public const IDENTICAL_ERROR = 'Passwords must be identical';

    #[Required]
    #[Length(min: User::MIN_PASSWORD_LENGTH, max: User::MAX_PASSWORD_LENGTH)]
    public string $password = '';

    #[Required]
    #[Length(min: User::MIN_PASSWORD_LENGTH, max: User::MAX_PASSWORD_LENGTH)]
    public string $passwordAgain = '';

    private function validatePassword(mixed $value, Callback $rule, ValidationContext $context): Result
    {
        $result = new Result();

        if ($this->password !== $this->passwordAgain) {
            return $result->addError(self::IDENTICAL_ERROR, valuePath: ['passwordAgain']);
        }

        return $result;
    }
}
