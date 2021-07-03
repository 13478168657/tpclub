<?php

return [

    'username' => env('MAIL_USERNAME'),

    'oauth' => [
        'appid' => env('APP_ID'),
        'app_secret' => env('APP_SECRET'),
        'wechat_auth_url' => env('WECHAT_AUTH_URL'),
        'wechat_access_token_url' => env('WECHAT_ACCESS_TOKEN_URL'),
        'wechat_access_user_url' => env('WECHAT_ACCESS_USER_URL'),
        'callback_url' => env('CALLBACK_URL')
    ],
];
