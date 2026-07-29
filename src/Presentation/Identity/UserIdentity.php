<?php

declare(strict_types=1);

namespace App\Presentation\Identity;

use App\Domain\User\AuthKeyGenerator;
use App\Domain\User\User;
use Override;
use Yiisoft\Auth\IdentityInterface;

final readonly class UserIdentity implements IdentityInterface
{
    public function __construct(public User $user, private AuthKeyGenerator $authKeyGenerator) {}

    #[Override]
    public function getId(): ?string
    {
        return (string) $this->user->getId();
    }
}
