<?php

    return array(
        'admin_objectequips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectequips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectequips/index',
            'children' => array(
                'view_objectequips',
                'create_objectequips',
                'update_objectequips',
                'delete_objectequips',
            ),
        ),
        
        'manager_objectequips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectequips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectequips/index',
            'children' => array(
                'view_objectequips',
                'create_objectequips',
                'update_objectequips',
            ),
        ),
        
        'user_objectequips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectequips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectequips/index',
            'children' => array(
                'view_objectequips',
            ),
        ),
        
        'view_objectequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_objectequips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_objectequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_objectequips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_objectequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_objectequips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_objectequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_objectequips',
            'bizRule' => null,
            'data' => null,
        ),
    );