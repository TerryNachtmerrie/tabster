<?php
    
return [
    'name' => 'routes',
    'config' => [
        ['GET', '/', 'Tabster\\Controllers\\IndexController#Index', 'index_index'],
        ['GET', '/users', 'userController#Index', 'user_index'],
    ]
];
