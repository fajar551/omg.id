<?php

return [
    /*
    |--------------------------------------------------------------------------
    | default
    |--------------------------------------------------------------------------
    |
    | The repository to use for establishing a feature's on/off state.
    |
    */

    'default' => 'database',

    /*
    |--------------------------------------------------------------------------
    | Config Feature Switches
    |--------------------------------------------------------------------------
    |
    | This is a set of features to load into the config features repository.
    |
    */

    'feature' => [
        // 'login' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Config Feature Name
    |--------------------------------------------------------------------------
    |
    | This is a set of available features name for generate features command.
    |
    */

    'feature_list' => [
        'auth_facebook' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'auth_twitter' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'auth_google' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'creator_page' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'manage_content' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'manage_page' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'explore' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
        'supporter_page' => [
            'production' => 'on',
            'development' => 'on',
            'local' => 'on',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | Configures the different repository options
    |
    */

    'repositories' => [
        'database' => [
            'table' => 'features',
        ],
        'config' => [
            'key' => 'features.feature',
        ],
        'redis' => [
            'prefix' => 'features',
            'connection' => 'default',
        ],
        'chain' => [
            'drivers' => [
                'config',
                'redis',
                'database',
            ],
            'store' => 'database',
            'update_on_resolve' => true,
        ],
    ],
];
