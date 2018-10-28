<?php

    return array(
        'admin_equips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'equips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'equips/index',
            'children' => array(
                'view_equips',
                'create_equips',
                'update_equips',
                'delete_equips',
            ),
        ),
        
        'manager_equips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'equips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'equips/index',
            'children' => array(
                'view_equips',
                'create_equips',
                'update_equips',
            ),
        ),
        
        'user_equips' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'equips',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'equips/index',
            'children' => array(
                'view_equips',
            ),
        ),
        
        'view_equips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_equips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_equips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_equips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_equips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_equips',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_equips' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_equips',
            'bizRule' => null,
            'data' => null,
        ),
    );