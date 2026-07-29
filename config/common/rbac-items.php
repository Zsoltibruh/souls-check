<?php

declare(strict_types=1);

use App\Presentation\Access\Permission;
use App\Presentation\Access\Role;
use Yiisoft\Rbac\Permission as RbacPermission;
use Yiisoft\Rbac\Role as RbacRole;

return [
    /** Roles */
    [
        'name' => Role::ADMIN->value,
        'type' => RbacRole::TYPE_ROLE,
        'children' => [
            Role::USER->value,
            Permission::MANAGE_GAMES->value,
            Permission::MANAGE_ANY_TASKLIST->value,
            Permission::MANAGE_USERS->value,
        ],
    ],

    [
        'name' => Role::USER->value,
        'type' => RbacRole::TYPE_ROLE,
        'children' => [
            Permission::CREATE_LIST->value,
            Permission::MANAGE_OWN_TASKLIST->value,
            Permission::MANAGE_OWN_PROFILE->value,
        ],
    ],

    /** Permissions */
    [
        'name' => Permission::CREATE_LIST->value,
        'type' => RbacPermission::TYPE_PERMISSION,
    ],

    /** Admin permissions */
    [
        'name' => Permission::MANAGE_ANY_TASKLIST->value,
        'type' => RbacPermission::TYPE_PERMISSION,
    ],
    [
        'name' => Permission::MANAGE_GAMES->value,
        'type' => RbacPermission::TYPE_PERMISSION,
    ],
    [
        'name' => Permission::MANAGE_USERS->value,
        'type' => RbacPermission::TYPE_PERMISSION,
    ],

    /** User permissions */
    [
        'name' => Permission::MANAGE_OWN_TASKLIST->value,
        'type' => RbacPermission::TYPE_PERMISSION,
    ],
    [
        'name' => Permission::MANAGE_OWN_PROFILE->value,
        'type' => RbacPermission::TYPE_PERMISSION
    ],
];
