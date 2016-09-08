<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Packtpub Email Address
    |--------------------------------------------------------------------------
    |
    | Packtpub email address.
    |
    */
    'email' => (getenv('PACKTPUB_EMAIL') ?: 'email@address.com'),

    /*
    |--------------------------------------------------------------------------
    | Packtpublr Password
    |--------------------------------------------------------------------------
    |
    | Packtpub password.
    |
    */
    'password' => (getenv('PACKTPUB_PASSWORD') ?: 'Password123'),

);