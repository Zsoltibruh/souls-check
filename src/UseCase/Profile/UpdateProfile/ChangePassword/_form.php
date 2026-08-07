<?php

declare(strict_types=1);

use App\Shared\UrlGenerator;
use App\UseCase\Profile\UpdateProfile\ChangePassword\Form;
use Yiisoft\FormModel\FieldFactory;
use Yiisoft\Html\Html;
use Yiisoft\User\CurrentUser;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var Form $form
 * @var Csrf $csrf
 * @var UrlGenerator $urlGenerator
 * @var CurrentUser $currentUser
 * @var string $actionUrl
 */

$actionUrl = $urlGenerator->updatePassword($currentUser->getId());

$field = new FieldFactory();
$htmlForm = Html::form()
    ->post($actionUrl)
    ->csrf($csrf);
?>

<div id="password-form-container">
    <h1>Update password</h1>
    <?= $field->errorSummary($form)->onlyCommonErrors() ?>

    <?= $htmlForm
        ->attribute('hx-post', $actionUrl)
        ->attribute('hx-target', '#password-form-container')
        ->attribute('hx-swap', 'outerHTML')
        ->open()
    ?>
    <?= $field->password($form, 'password')->required() ?>
    <?= $field->password($form, 'passwordAgain')->required() ?>
    <?= $field->submitButton('Update') ?>
    <?= $htmlForm->close() ?>
</div>