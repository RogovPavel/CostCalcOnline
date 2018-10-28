<?php

    return array(
        'admin_streets' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'streets',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'streets/index',
            'children' => array(
                'view_streets',
                'create_streets',
                'update_streets',
                'delete_streets',
            ),
        ),
        
        'manager_streets' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'streets',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'streets/index',
            'children' => array(
                'view_streets',
                'create_streets',
                'update_streets',
            ),
        ),
        
        'user_streets' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'streets',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'streets/index',
            'children' => array(
                'view_streets',
            ),
        ),
        
        'view_streets' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_streets',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_streets' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_streets',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_streets' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_streets',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_streets' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_streets',
            'bizRule' => null,
            'data' => null,
        ),
    );