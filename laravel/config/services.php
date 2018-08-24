<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
    'client_id' => '559217684476377',
    'client_secret' => '30e0355df437d01074869d784e2404b8',
    'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],

    'google' => [
    'client_id' => '450614237882-al10sqcpoc69f5mscpjn1vfvmjkogn47.apps.googleusercontent.com',
    'client_secret' => 'qcPKpDH4FmIjGwll38plE_Ej',
    'redirect' => 'http://localhost:8000/api/auth/login/google/callback',
    ],

];
