<?php

    return array(
        'admin_tariffs' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'tariffs',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'tariffs/index',
            'children' => array(
                'view_tariffs',
                'create_tariffs',
                'update_tariffs',
                'delete_tariffs',
            ),
        ),
        
        'manager_tariffs' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'tariffs',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'tariffs/index',
            'children' => array(
                'view_tariffs',
                'create_tariffs',
                'update_tariffs',
            ),
        ),
        
        'user_tariffs' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'tariffs',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'tariffs/index',
            'children' => array(
                'view_tariffs',
            ),
        ),
        
        'view_tariffs' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_tariffs',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_tariffs' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_tariffs',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_tariffs' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_tariffs',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_tariffs' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_tariffs',
            'bizRule' => null,
            'data' => null,
        ),
    );