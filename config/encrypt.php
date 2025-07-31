<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table Encryption Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for database encryption on specific column
    | 
    |
    */

    'enable' => env('ENABLE_ENCRYPT', false),

    // Important Note!: if you want add another encrypted column, please decrypt first the last encrypted column 
    // bacause if you run php artisan encryptable:encryptModel/decryptModel command but already encrypted data in the table
    // it possible broke your data 
    'table' => [
        'users' => [
            'name', 
            'phone_number',
            'address', 
            'address_city', 
            'address_province', 
            'address_district', 
        ],
    
        'pages' => [],
    ],

];
