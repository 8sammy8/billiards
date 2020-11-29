<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Project configurations
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'currency' => env('CURRENCY', 'UZS'),
    
    'image' => [
        'product' => [
            'width' => 150,
            'height' => 100,
        ],
    ],

    'order_table_limits' => [
        'LIMIT_FREE' => 0, 'LIMIT_TIME' => 1, 'LIMIT_PRICE' => 2
    ]
];
