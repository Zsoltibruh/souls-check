<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use App\Shared\UrlGenerator;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Definitions\Reference;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\CsrfViewInjection;

return [
    'application' => require __DIR__ . '/application.php',

    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],

    'yiisoft/yii-gii' => [
        'enabled' => true,
        'allowedIPs' => ['*'],
        'baseUrl' => '/gii',
    ],
];
