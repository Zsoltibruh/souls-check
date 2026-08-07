<?php

namespace App\Presentation\Access\Rule;

use Yiisoft\Rbac\Item;
use Yiisoft\Rbac\RuleContext;
use Override;
use Yiisoft\Rbac\RuleInterface;

final class ProfileOwnerRule implements RuleInterface
{
    #[Override]
    public function execute(?string $userId, Item $item, RuleContext $context): bool
    {
        $targetUserId = $context->getParameters()['userId'] ?? null;

        return $userId !== null && $targetUserId !== null && $userId === $targetUserId;
    }
}
