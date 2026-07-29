<?php

declare(strict_types=1);

namespace App\UseCase\Users\Create;

use App\Domain\User\User;
use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Label;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;

final class Form extends FormModel
{
    #[Label('Username')]
    #[Length(min: User::MIN_USERNAME_LENGTH)]
    #[Required]
    public string $username = '';

    #[Label('Email')]
    #[Required]
    public string $email = '';

    #[Label('Password')]
    #[Length(min: User::MIN_PASSWORD_LENGTH, max: User::MAX_PASSWORD_LENGTH)]
    #[Required]
    public string $password = '';
}
