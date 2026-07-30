<?php

declare(strict_types=1);

use App\Presentation\Access\GuestOnly;
use App\Web;
use Yiisoft\Auth\Middleware\Authentication;
use Yiisoft\Http\Method;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;

return [
    Group::create()
        ->routes(
            Route::get('/')
                ->action(App\UseCase\HomePage\Action::class)
                ->name('home'),

            Route::methods([Method::GET, Method::POST], '/signup')
                ->middleware(GuestOnly::class)
                ->action(App\UseCase\Users\Create\Action::class)
                ->name('signup'),
            Route::methods([Method::GET, Method::POST], '/login')
                ->middleware(GuestOnly::class)
                ->action(App\UseCase\Login\Action::class)
                ->name('login'),

            Route::post('/logout')
                ->middleware(Authentication::class)
                ->action(App\UseCase\Logout\Action::class)
                ->name('logout'),
        ),

    Group::create('/profile')
        ->routes(
            Route::get('/{id}')
                ->action(App\UseCase\Profile\ViewProfile\Action::class)
                ->name('view-profile')
        )
];
