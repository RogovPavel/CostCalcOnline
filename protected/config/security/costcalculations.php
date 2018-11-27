<?php

    return array(
        'admin_costcalculations' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalculations',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalculations/index',
            'children' => array(
                'view_costcalculations',
                'create_costcalculations',
                'update_costcalculations',
                'delete_costcalculations',
            ),
        ),
        
        'manager_costcalculations' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalculations',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalculations/index',
            'children' => array(
                'view_costcalculations',
                'create_costcalculations',
                'update_costcalculations',
            ),
        ),
        
        'user_costcalculations' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalculations',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalculations/index',
            'children' => array(
                'view_costcalculations',
            ),
        ),
        
        'view_costcalculations' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_costcalculations',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_costcalculations' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_costcalculations',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_costcalculations' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_costcalculations',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_costcalculations' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_costcalculations',
            'bizRule' => null,
            'data' => null,
        ),
    );