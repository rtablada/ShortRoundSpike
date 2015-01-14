<?php

return [

    'initialize' => function ($authority) {
        $user = $authority->getCurrentUser();

        $authority->addAlias('manage', ['create', 'read', 'update', 'delete']);
        $authority->addAlias('moderate', ['read', 'update', 'delete']);
    }

];
