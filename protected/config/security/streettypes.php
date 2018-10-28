<?php

    return array(
        'admin_streettypes' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'streettypes',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'streettypes/index',
            'children' => array(
                'view_streettypes',
                'create_streettypes',
                'update_streettypes',
                'delete_streettypes',
            ),
        ),
        
        'manager_streettypes' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'streettypes',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'streettypes/index',
            'children' => array(
                'view_streettypes',
                'create_streettypes',
                'update_streettypes',
            ),
        ),
        
        'user_streettypes' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'streettypes',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'streettypes/index',
            'children' => array(
                'view_streettypes',
            ),
        ),
        
        'view_streettypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_streettypes',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_streettypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_streettypes',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_streettypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_streettypes',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_streettypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_streettypes',
            'bizRule' => null,
            'data' => null,
        ),
    );