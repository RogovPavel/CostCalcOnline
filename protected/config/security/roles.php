<?php

    return array(
        'admin_roles' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'roles',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'roles/index',
            'children' => array(
                'view_roles',
                'create_roles',
                'update_roles',
                'delete_roles',
            ),
        ),
        
        'manager_roles' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'roles',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'roles/index',
            'children' => array(
                'view_roles',
                'create_roles',
                'update_roles',
            ),
        ),
        
        'user_roles' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'roles',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'roles/index',
            'children' => array(
                'view_roles',
            ),
        ),
        
        'view_roles' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_roles',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_roles' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_roles',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_roles' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_roles',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_roles' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_roles',
            'bizRule' => null,
            'data' => null,
        ),
    );