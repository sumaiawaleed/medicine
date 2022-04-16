<?php

return [

    'create_users' => false,
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'admins' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'cities' => 'c,r,u,d',
            'areas' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'clients' => 'c,r,u,d',
            'client_fin_accounts' => 'c,r,u,d',
            'orders' => 'c,r,u,d',
            'invoices' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product_units' => 'c,r,u,d',
            'product_conversion_units' => 'c,r,u,d',
            'order_items' => 'c,r,u,d',
            'receipts' => 'c,r,u,d',
            'return_invoices' => 'c,r,u,d',
            'locations' => 'c,r,u,d',
            'user_locations' => 'c,r,u,d',
            'tasks' => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
