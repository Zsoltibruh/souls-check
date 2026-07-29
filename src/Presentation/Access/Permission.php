<?php

declare(strict_types=1);

namespace App\Presentation\Access;

enum Permission: string
{
    /** User permissions */
    case CREATE_LIST = 'createList';
    case MANAGE_OWN_TASKLIST = 'manageOwnTasklist';
    case MANAGE_OWN_PROFILE = 'manageOwnProfile';

    /** Admin permissions */
    case MANAGE_GAMES = 'manageGames';
    case MANAGE_USERS = 'manageUsers';
    case MANAGE_ANY_TASKLIST = 'manageAnyTasklist';
}
