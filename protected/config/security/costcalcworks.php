<?php

    return array(
        'admin_costcalcworks' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcworks',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcworks/index',
            'children' => array(
                'view_costcalcworks',
                'create_costcalcworks',
                'update_costcalcworks',
                'delete_costcalcworks',
            ),
        ),
        
        'manager_costcalcworks' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcworks',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcworks/index',
            'children' => array(
                'view_costcalcworks',
                'create_costcalcworks',
                'update_costcalcworks',
            ),
        ),
        
        'user_costcalcworks' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcworks',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcworks/index',
            'children' => array(
                'view_costcalcworks',
            ),
        ),
        
        'view_costcalcworks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_costcalcworks',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_costcalcworks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_costcalcworks',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_costcalcworks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_costcalcworks',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_costcalcworks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_costcalcworks',
            'bizRule' => null,
            'data' => null,
        ),
    );