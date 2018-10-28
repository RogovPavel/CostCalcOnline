<?php

    return array(
        'admin_firms' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'firms',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'firms/index',
            'children' => array(
                'view_firms',
                'create_firms',
                'update_firms',
                'delete_firms',
            ),
        ),
        
        'manager_firms' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'firms',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'firms/index',
            'children' => array(
                'view_firms',
                'create_firms',
                'update_firms',
            ),
        ),
        
        'user_firms' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'firms',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'firms/index',
            'children' => array(
                'view_firms',
            ),
        ),
        
        'view_firms' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_firms',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_firms' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_firms',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_firms' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_firms',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_firms' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_firms',
            'bizRule' => null,
            'data' => null,
        ),
    );