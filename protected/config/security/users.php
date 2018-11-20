<?php

    return array(
        'admin_users' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'users',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'users/index',
            'children' => array(
                'view_users',
                'create_users',
                'update_users',
                'delete_users',
            ),
        ),
        
        'manager_users' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'users',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'users/index',
            'children' => array(
                'view_users',
                'create_users',
                'update_users',
            ),
        ),
        
        'user_users' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'users',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'users/index',
            'children' => array(
                'view_users',
            ),
        ),
        
        'view_users' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_users',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_users' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_users',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_users' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_users',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_users' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_users',
            'bizRule' => null,
            'data' => null,
        ),
    );