<?php

declare(strict_types=1);

namespace App\Presentation\Identity;

use App\Domain\User\AuthKeyGenerator;
use App\Domain\User\User;
use Yiisoft\Auth\IdentityInterface;
use Override;
use Yiisoft\Auth\IdentityRepositoryInterface;

final readonly class IdentityRepository implements IdentityRepositoryInterface
{
    public function __construct(private AuthKeyGenerator $authKeyGenerator) {}

    #[Override]
    public function findIdentity(string $id): ?IdentityInterface
    {
        /** @var User|null $user */
        $user = User::query()->findByPk($id);
        if ($user === null) {
            return null;
        }

        return new UserIdentity($user, $this->authKeyGenerator);
    }
}
