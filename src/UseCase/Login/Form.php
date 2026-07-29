<?php

declare(strict_types=1);

namespace App\UseCase\Login;

use App\Domain\User\User;
use Yiisoft\FormModel\Attribute\Safe;
use Yiisoft\FormModel\FormModel;
use Yiisoft\Hydrator\Attribute\Parameter\Trim;
use Yiisoft\Validator\Label;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;

final class Form extends FormModel
{
    public const ERROR_MESSAGE = 'Incorrect username or password!';

    #[Label('Username')]
    #[Trim]
    #[Required]
    public string $username = '';

    #[Label('Password')]
    #[Required]
    public string $password = '';

    #[Safe]
    public bool $rememberMe = false;

    private function validateUsernameAndPassword(): Result
    {
        $result = new Result();
        if (
            mb_strlen($this->username) < User::MIN_USERNAME_LENGTH
            || mb_strlen($this->password) < User::MIN_PASSWORD_LENGTH
            || mb_strlen($this->password) > User::MAX_PASSWORD_LENGTH
        ) {
            $result->addError(self::ERROR_MESSAGE);
        }

        return $result;
    }
}
