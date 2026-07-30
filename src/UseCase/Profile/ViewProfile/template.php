<?php

declare(strict_types=1);

use App\Domain\User\User;
use App\Shared\ApplicationParams;
use App\Shared\Formatter;
use App\Shared\UrlGenerator;
use Yiisoft\Html\Html;
use Yiisoft\View\WebView;

/**
 * @var ApplicationParams $applicationParams
 * @var WebView $this
 * @var User $user
 * @var UrlGenerator $urlGenerator
 * @var Formatter $formatter
 */

$this->setTitle($applicationParams->name . ' | Profile');
?>

<p><?= Html::a('Go home', $urlGenerator->home()) ?></p>

<div>
    <h1><?= Html::encode($user->getUsername()) ?></h1>
    <hr>
    <p>Joined: <?= Html::encode($formatter->asLongDate($user->getCreatedAt())) ?></p>
</div>