<?php

    return array(
        'admin_banks' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'banks',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'banks/index',
            'children' => array(
                'view_banks',
                'create_banks',
                'update_banks',
                'delete_banks',
            ),
        ),
        
        'manager_banks' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'banks',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'banks/index',
            'children' => array(
                'view_banks',
                'create_banks',
                'update_banks',
            ),
        ),
        
        'user_banks' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'banks',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'banks/index',
            'children' => array(
                'view_banks',
            ),
        ),
        
        'view_banks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_banks',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_banks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_banks',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_banks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_banks',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_banks' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_banks',
            'bizRule' => null,
            'data' => null,
        ),
    );