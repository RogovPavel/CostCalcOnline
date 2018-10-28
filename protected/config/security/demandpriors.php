<?php

    return array(
        'admin_demandpriors' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandpriors',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandpriors/index',
            'children' => array(
                'view_demandpriors',
                'create_demandpriors',
                'update_demandpriors',
                'delete_demandpriors',
            ),
        ),
        
        'manager_demandpriors' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandpriors',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandpriors/index',
            'children' => array(
                'view_demandpriors',
                'create_demandpriors',
                'update_demandpriors',
            ),
        ),
        
        'user_demandpriors' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandpriors',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandpriors/index',
            'children' => array(
                'view_demandpriors',
            ),
        ),
        
        'view_demandpriors' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_demandpriors',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_demandpriors' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_demandpriors',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_demandpriors' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_demandpriors',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_demandpriors' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_demandpriors',
            'bizRule' => null,
            'data' => null,
        ),
    );