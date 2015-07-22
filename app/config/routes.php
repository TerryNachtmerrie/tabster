<?php
    
return [
    'name' => 'routes',
    'config' => [
        ['GET', '/', 'index#index', 'index_index'],
        ['GET', '/users', 'users#index', 'user_index'],
    ]
];
