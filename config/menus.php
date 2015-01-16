<?php

return [
    [
        'name'     => 'Admin',
        'url' => '/admin',
        'children' => [
            [
                'name' => 'Users',
                'url'  => 'users',
            ],
            [
                'name' => 'Menus',
                'url'  => 'menus',
            ],
            [
                'name' => 'Copy',
                'url'  => 'copy',
            ],
            [
                'name' => 'Settings',
                'url'  => 'site-settings',
            ],
        ],
    ],
    [
        'name'     => 'Admin Top',
        'url' => '/admin',
        'children' => [
            [
                'name' => 'Settings',
                'url' => 'site-settings',
                'class' => 'fa fa-cog fa-fw',
            ],
            [
                'name' => 'Users',
                'url'  => 'users',
                'class' => 'fa fa-user fa-fw',
                'children' => [
                    [
                        'name' => 'Logout',
                        'url'  => '/logout',
                        'class' => 'fa fa-sign-out fa-fw'
                    ],
                    [
                        'name' => 'Profile',
                        'url'  => 'profile',
                        'class' => 'fa fa-user fa-fw'
                    ],
                ]
            ],
        ]
    ],
];
