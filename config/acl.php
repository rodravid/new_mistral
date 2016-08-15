<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'entity' => Vinci\Domain\ACL\Role\Role::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Available drivers: config|doctrine
    | When set to config, add the permission names to list
    |
    */
    'permissions' => [
        'driver' => 'config',
        'entity' => Vinci\Domain\ACL\Permission\Permission::class,
        'list'   => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Organisations
    |--------------------------------------------------------------------------
    */
    'organisations' => [
        'entity' => Vinci\Domain\ACL\Organisation::class,
    ],
];
