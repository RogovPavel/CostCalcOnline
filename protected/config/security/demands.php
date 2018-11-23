<?php

    return array(
        'admin_demands' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demands',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demands/index',
            'children' => array(
                'view_demands',
                'create_demands',
                'update_demands',
                'delete_demands',
            ),
        ),
        
        'manager_demands' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demands',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demands/index',
            'children' => array(
                'view_demands',
                'create_demands',
                'update_demands',
            ),
        ),
        
        'user_demands' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demands',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demands/index',
            'children' => array(
                'view_demands',
            ),
        ),
        
        'view_demands' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_demands',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_demands' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_demands',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_demands' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_demands',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_demands' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_demands',
            'bizRule' => null,
            'data' => null,
        ),
    );