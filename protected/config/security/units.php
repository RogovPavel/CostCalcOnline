<?php

    return array(
        'admin_units' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'units',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'units/index',
            'children' => array(
                'view_units',
                'create_units',
                'update_units',
                'delete_units',
            ),
        ),
        
        'manager_units' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'units',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'units/index',
            'children' => array(
                'view_units',
                'create_units',
                'update_units',
            ),
        ),
        
        'user_units' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'units',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'units/index',
            'children' => array(
                'view_units',
            ),
        ),
        
        'view_units' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_units',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_units' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_units',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_units' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_units',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_units' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_units',
            'bizRule' => null,
            'data' => null,
        ),
    );