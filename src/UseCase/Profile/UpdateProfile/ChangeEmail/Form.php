<?php

declare(strict_types=1);

namespace App\UseCase\Profile\UpdateProfile\ChangeEmail;

use App\Domain\User\User;
use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Required;

final class Form extends FormModel
{
    #[Required]
    #[Email]
    public string $email = '';

    public function __construct(User $user)
    {
        $this->email = $user->getEmail();
    }
}
