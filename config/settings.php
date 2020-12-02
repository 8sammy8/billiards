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
    ],

    'print' => [
        'bill' => 'Hisob',
        'cost_1_hour' => '1 soatlik o\'yin narxi',
        'game_start_time' => 'O\'yinning boshlanish vaqti',
        'game_end_time' => 'O\'yin tugash vaqti',
        'bar' => 'Bar',
        'name' => 'Nomi',
        'amount' => 'Miqdori',
        'total' => 'Jami',
        'amount_bar' => '',
        'bar_amount' => 'Bar tol\'vi',
        'billiards_amount' => 'Bilyard tol\'vi',
        'total_amount' => 'To\'lov miqdori',
    ]
];
