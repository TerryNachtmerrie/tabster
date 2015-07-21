<?php
    
return [
    'name' => 'routes',
    'config' => [
        ['GET', '/', 'IndexController#Index', 'index_index'],
        ['GET', '/users', 'userController#Index', 'user_index'],
    ]
];
