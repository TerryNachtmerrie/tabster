<?php

return [
    'name'   => 'cookie',
    'config' => [
        'key'      => '4a7a9cb485b149d7', // 16 bit key for defuse/php-encryption
        'expire'   => 2592000,            // Cookie expire time
        'path'     => '/',                // Cookie path
        'domain'   => 'example.com',      // Cookie domain
        'secure'   => false,              // Set secure cookie(https)
        'httponly' => true,               // HTTP only cookies
    ],
];
