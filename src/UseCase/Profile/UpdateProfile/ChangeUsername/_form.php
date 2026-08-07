<?php

declare(strict_types=1);

use App\Shared\UrlGenerator;
use App\UseCase\Profile\UpdateProfile\ChangeUsername\Form;
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

$actionUrl = $urlGenerator->updateUsername($currentUser->getId());

$field = new FieldFactory();
$htmlForm = Html::form()
    ->post($actionUrl)
    ->csrf($csrf);
?>

<div id="username-form-container">
    <h1>Update username</h1>
    <?= $field->errorSummary($form)->onlyCommonErrors() ?>

    <?= $htmlForm
        ->attribute('hx-post', $actionUrl)
        ->attribute('hx-target', '#username-form-container')
        ->attribute('hx-swap', 'outerHTML')
        ->open()
    ?>
    <?= $field->text($form, 'username')->required() ?>
    <?= $field->submitButton('Update') ?>
    <?= $htmlForm->close() ?>
</div>