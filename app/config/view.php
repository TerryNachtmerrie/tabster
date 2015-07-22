<?php

return [
    'name'   => 'view',
    'config' => [
        'templatePath' => APP_PATH . '/app/views',
        'environmentOptions' => [
            'debug' => true,
            'cache' => false,
            'strict_variables' => true,
        ],
    ],
];
