<?php

    return array(
        'admin_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcpayments',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcpayments/index',
            'children' => array(
                'view_costcalcpayments',
                'create_costcalcpayments',
                'update_costcalcpayments',
                'delete_costcalcpayments',
            ),
        ),
        
        'manager_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcpayments',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcpayments/index',
            'children' => array(
                'view_costcalcpayments',
                'create_costcalcpayments',
                'update_costcalcpayments',
            ),
        ),
        
        'user_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'costcalcpayments',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'costcalcpayments/index',
            'children' => array(
                'view_costcalcpayments',
            ),
        ),
        
        'view_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_costcalcpayments',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_costcalcpayments',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_costcalcpayments',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_costcalcpayments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_costcalcpayments',
            'bizRule' => null,
            'data' => null,
        ),
    );