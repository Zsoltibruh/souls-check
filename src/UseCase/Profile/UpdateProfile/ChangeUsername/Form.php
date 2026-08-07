<?php

declare(strict_types=1);

namespace App\UseCase\Profile\UpdateProfile\ChangeUsername;

use App\Domain\User\User;
use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;

final class Form extends FormModel
{
    #[Required]
    #[Length(min: User::MIN_USERNAME_LENGTH)]
    public string $username = '';

    public function __construct(User $user)
    {
        $this->username = $user->getUsername();
    }
}
