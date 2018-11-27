<?php

    return array(
        'admin_costcalcequips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcequips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcequips/index',
            'children' => array(
                'view_costcalcequips',
                'create_costcalcequips',
                'update_costcalcequips',
                'delete_costcalcequips',
            ),
        ),
        
        'manager_costcalcequips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcequips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcequips/index',
            'children' => array(
                'view_costcalcequips',
                'create_costcalcequips',
                'update_costcalcequips',
            ),
        ),
        
        'user_costcalcequips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcequips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcequips/index',
            'children' => array(
                'view_costcalcequips',
            ),
        ),
        
        'view_costcalcequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_costcalcequips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_costcalcequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_costcalcequips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_costcalcequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_costcalcequips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_costcalcequips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_costcalcequips',
            'bizRule' => null,
            'data' => null,
        ),
    );