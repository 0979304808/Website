<?php

return [
    'account' => [
        'admin' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD')
    ],
    'password_default' => 'abc',
    'ftp' => [
        'host' => env('FTP_HOST'),
        'space' => 'assets/mazii_data/user_data/',
        'link' => 'https://data.mazii.net/user_data/'
    ],
];