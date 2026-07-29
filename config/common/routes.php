<?php

declare(strict_types=1);

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
                ->action(App\UseCase\Users\Create\Action::class)
                ->name('signup'),
            Route::methods([Method::GET, Method::POST], '/login')
                ->action(App\UseCase\Login\Action::class)
                ->name('login'),
            Route::post('/logout')
                ->middleware(Authentication::class)
                ->action(App\UseCase\Logout\Action::class)
                ->name('logout'),
        ),
];
