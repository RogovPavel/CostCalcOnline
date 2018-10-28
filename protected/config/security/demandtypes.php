<?php

    return array(
        'admin_demandtypes' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandtypes',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandtypes/index',
            'children' => array(
                'view_demandtypes',
                'create_demandtypes',
                'update_demandtypes',
                'delete_demandtypes',
            ),
        ),
        
        'manager_demandtypes' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandtypes',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandtypes/index',
            'children' => array(
                'view_demandtypes',
                'create_demandtypes',
                'update_demandtypes',
            ),
        ),
        
        'user_demandtypes' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandtypes',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandtypes/index',
            'children' => array(
                'view_demandtypes',
            ),
        ),
        
        'view_demandtypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_demandtypes',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_demandtypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_demandtypes',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_demandtypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_demandtypes',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_demandtypes' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_demandtypes',
            'bizRule' => null,
            'data' => null,
        ),
    );