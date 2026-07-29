<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use App\Shared\UrlGenerator;
use App\UseCase\Login\Form;
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

$this->setTitle($applicationParams->name . ' | Login');

$htmlForm = Html::form()
    ->post($urlGenerator->login())
    ->csrf($csrf);

$field = new FieldFactory();
?>

<h1>Login</h1>
<?= $field->errorSummary($form)->onlyCommonErrors() ?>
<?= $htmlForm->open() ?>
<?= $field->text($form, 'username')->required() ?>
<?= $field->password($form, 'password')->required() ?>
<?= $field->checkbox($form, 'rememberMe') ?>
<?= $field->submitButton('Login') ?>
<?= $htmlForm->close() ?>