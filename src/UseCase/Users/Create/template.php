<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use App\Shared\UrlGenerator;
use App\UseCase\Users\Create\Form;
use Yiisoft\FormModel\FieldFactory;
use Yiisoft\Html\Html;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/** 
 * @var ApplicationParams $applicationParams
 * @var Csrf $csrf
 * @var Form $form
 * @var WebView $this
 * @var UrlGenerator $urlGenerator
 * */

$this->setTitle($applicationParams->name . ' | Sign up');

$htmlForm = Html::form()
    ->post($urlGenerator->signup())
    ->csrf($csrf);

$field = new FieldFactory();
?>

<h1>Sign up</h1>
<?= $field->errorSummary($form)->onlyCommonErrors() ?>
<?= $htmlForm->open() ?>
<?= $field->text($form, 'username')->required() ?>
<?= $field->text($form, 'email')->required() ?>
<?= $field->password($form, 'password')->required() ?>
<?= $field->submitButton('Sign up') ?>
<?= $htmlForm->close() ?>