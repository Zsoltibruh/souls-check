<?php

declare(strict_types=1);

use App\Presentation\Layout\Layout;
use App\Shared\ApplicationParams;
use App\Shared\UrlGenerator;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Definitions\Reference;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\User\CurrentUser;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\CsrfViewInjection;
use Yiisoft\Yii\View\Renderer\InjectionContainer\InjectionContainer;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

return [
    WebView::class => [
        'setParameters()' => [
            [
                'assetManager' => Reference::to(AssetManager::class),
                'applicationParams' => Reference::to(ApplicationParams::class),
                'aliases' => Reference::to(Aliases::class),
                'urlGenerator' => Reference::to(UrlGenerator::class),
                'currentRoute' => Reference::to(CurrentRoute::class),
                'currentUser' => Reference::to(CurrentUser::class),
            ]
        ]
    ],

    WebViewRenderer::class => [
        '__construct()' => [
            'layout' => Layout::MAIN,
            'injections' => [
                Reference::to(CsrfViewInjection::class),
            ],
            'injectionContainer' => Reference::to(InjectionContainer::class),
        ]
    ],
];
