<?php

declare(strict_types=1);

use App\Domain\User\User;
use App\Presentation\Access\Permission;
use App\Shared\ApplicationParams;
use App\Shared\Formatter;
use App\Shared\UrlGenerator;
use Yiisoft\Html\Html;
use Yiisoft\User\CurrentUser;
use Yiisoft\View\WebView;

/**
 * @var ApplicationParams $applicationParams
 * @var WebView $this
 * @var User $user
 * @var UrlGenerator $urlGenerator
 * @var Formatter $formatter
 * @var CurrentUser $currentUser
 */

$this->setTitle($applicationParams->name . ' | Profile');
?>

<p><?= Html::a('Go home', $urlGenerator->home()) ?></p>

<div>
    <h1><?= Html::encode($user->getUsername()) ?></h1>
    <hr>
    <p>Joined: <?= Html::encode($formatter->asLongDate($user->getCreatedAt())) ?></p>
    <?php if ($currentUser->can(Permission::MANAGE_OWN_PROFILE, ['userId' => $user->getId()])): ?>
        <?= Html::a('Update profile', $urlGenerator->updateProfile($user->getId())) ?>
    <?php endif; ?>
</div>