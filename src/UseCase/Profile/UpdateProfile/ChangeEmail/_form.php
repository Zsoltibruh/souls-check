<?php

declare(strict_types=1);

use App\Shared\UrlGenerator;
use App\UseCase\Profile\UpdateProfile\ChangeEmail\Form;
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

$actionUrl = $urlGenerator->updateEmail($currentUser->getId());

$field = new FieldFactory();
$htmlForm = Html::form()
    ->post($actionUrl)
    ->csrf($csrf);
?>

<div id="email-form-container">
    <h1>Update email</h1>
    <?= $field->errorSummary($form)->onlyCommonErrors() ?>

    <?= $htmlForm
        ->attribute('hx-post', $actionUrl)
        ->attribute('hx-target', '#email-form-container')
        ->attribute('hx-swap', 'outerHTML')
        ->open()
    ?>
    <?= $field->text($form, 'email')->required() ?>
    <?= $field->submitButton('Update') ?>
    <?= $htmlForm->close() ?>
</div>