<?php

    return array(
        'admin_objects' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objects',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objects/index',
            'children' => array(
                'view_objects',
                'create_objects',
                'update_objects',
                'delete_objects',
            ),
        ),
        
        'manager_objects' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objects',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objects/index',
            'children' => array(
                'view_objects',
                'create_objects',
                'update_objects',
            ),
        ),
        
        'user_objects' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objects',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objects/index',
            'children' => array(
                'view_objects',
            ),
        ),
        
        'view_objects' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_objects',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_objects' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_objects',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_objects' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_objects',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_objects' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_objects',
            'bizRule' => null,
            'data' => null,
        ),
    );