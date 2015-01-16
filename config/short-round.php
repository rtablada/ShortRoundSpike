<?php

return [
    'menus' => [
        /**
         * Set the menu driver to use
         *
         * Available drivers: array, db
         *
         * Array Driver pulls in menus from config/menus.php
         * DB Driver loads in dynamic menus, seeded from MenuSeeder or edited in DB/Dashboard
         */
        'driver' => 'array',
    ],

    'gadgets' => [
        'copy' => 'App\\Gadgets\\Copy',
        'site-settings' => 'App\\Gadgets\\SiteSetting',
    ],

    'gateways' => [
        'site-settings' => 'App\\Gateways\\DbSiteSettingGateway',
        'copy' => 'App\\Gateways\\DbCopyGateway',
    ]
];
