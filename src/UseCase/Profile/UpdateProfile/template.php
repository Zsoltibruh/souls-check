<?php

declare(strict_types=1);

use App\Domain\User\User;
use App\Shared\ApplicationParams;
use App\Shared\Formatter;
use App\Shared\UrlGenerator;
use App\UseCase\Profile\UpdateProfile\ChangeUsername\Form as UsernameForm;
use App\UseCase\Profile\UpdateProfile\ChangeEmail\Form as EmailForm;
use App\UseCase\Profile\UpdateProfile\ChangePassword\Form as PasswordForm;
use Yiisoft\User\CurrentUser;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var ApplicationParams $applicationParams
 * @var Csrf $csrf
 * @var CurrentUser $currentUser
 * @var UsernameForm $usernameForm
 * @var EmailForm $emailForm
 * @var PasswordForm $passwordForm
 * @var Formatter $formatter
 * @var UrlGenerator $urlGenerator
 * @var User $user
 * @var WebView $this
 */

$this->setTitle($applicationParams->name . ' | Update profile');
?>

<?= $this->render(__DIR__ . '/ChangeUsername/_form', [
    'form' => $usernameForm,
]) ?>

<?= $this->render(__DIR__ . '/ChangeEmail/_form', [
    'form' => $emailForm,
]) ?>

<?= $this->render(__DIR__ . '/ChangePassword/_form', [
    'form' => $passwordForm,
]) ?>