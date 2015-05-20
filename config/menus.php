<?php

return [
    [
        'name'     => 'Admin',
        'url'      => '/admin',
        'children' => [
            [
                'name'  => 'Users',
                'url'   => 'users',
                'roles' => [
                    'admin'
                ]
            ],
            [
                'name' => 'Copy',
                'url'  => 'copy',
                'roles' => [
                    'admin'
                ]
            ],
            [
                'name' => 'Settings',
                'url'  => 'site-settings',
                'roles' => [
                    'admin'
                ]
            ],
        ],
    ],
    [
        'name'     => 'Admin Top',
        'url'      => '/admin',
        'children' => [
            [
                'name'  => 'Settings',
                'url'   => 'site-settings',
                'class' => 'fa fa-cog fa-fw',
                'roles' => [
                    'admin'
                ]
            ],
            [
                'name'     => 'Users',
                'class'    => 'fa fa-user fa-fw',
                'children' => [
                    [
                        'name'  => 'Profile',
                        'url'   => 'profile',
                        'class' => 'fa fa-user fa-fw'
                    ],
                    [
                        'name'  => 'Logout',
                        'url'   => '/logout',
                        'class' => 'fa fa-sign-out fa-fw'
                    ],
                ],
            ],
        ]
    ],
];
