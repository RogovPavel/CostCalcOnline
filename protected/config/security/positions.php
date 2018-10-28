<?php

    return array(
        'admin_positions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'positions',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'positions/index',
            'children' => array(
                'view_positions',
                'create_positions',
                'update_positions',
                'delete_positions',
            ),
        ),
        
        'manager_positions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'positions',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'positions/index',
            'children' => array(
                'view_positions',
                'create_positions',
                'update_positions',
            ),
        ),
        
        'user_positions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'positions',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'positions/index',
            'children' => array(
                'view_positions',
            ),
        ),
        
        'view_positions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_positions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_positions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_positions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_positions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_positions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_positions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_positions',
            'bizRule' => null,
            'data' => null,
        ),
    );