<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Jalur URL mana yang diizinkan untuk diakses lintas domain.
    // 'api/*' artinya semua route di file api.php boleh diakses.
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Method HTTP apa yang diizinkan (GET, POST, PUT, DELETE, dll).
    // '*' artinya semua diizinkan.
    'allowed_methods' => ['*'],

    // Siapa yang boleh mengakses?
    // '*' artinya SEMUA website boleh mengakses API ini (Sangat mudah untuk Dev).
    // Untuk keamanan produksi nanti, ganti '*' dengan 'http://localhost:5173'.
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    // Header apa yang boleh dikirim (misal: Authorization, Content-Type).
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Apakah mengizinkan kredensial seperti Cookies/Session?
    // Set true jika nanti menggunakan Sanctum dengan cookie, tapi false juga oke untuk Token Bearer biasa.
    'supports_credentials' => false,

];
