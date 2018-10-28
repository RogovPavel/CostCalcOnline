<?php

    return array(
        'admin_clients' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'clients',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'clients/index',
            'children' => array(
                'view_clients',
                'create_clients',
                'update_clients',
                'delete_clients',
            ),
        ),
        
        'manager_clients' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'clients',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'clients/index',
            'children' => array(
                'view_clients',
                'create_clients',
                'update_clients',
            ),
        ),
        
        'user_clients' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'clients',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'clients/index',
            'children' => array(
                'view_clients',
            ),
        ),
        
        'view_clients' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_clients',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_clients' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_clients',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_clients' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_clients',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_clients' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_clients',
            'bizRule' => null,
            'data' => null,
        ),
    );