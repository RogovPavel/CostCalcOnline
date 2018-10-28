<?php

    return array(
        'admin_demandstatus' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandstatus',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandstatus/index',
            'children' => array(
                'view_demandstatus',
                'create_demandstatus',
                'update_demandstatus',
                'delete_demandstatus',
            ),
        ),
        
        'manager_demandstatus' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandstatus',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandstatus/index',
            'children' => array(
                'view_demandstatus',
                'create_demandstatus',
                'update_demandstatus',
            ),
        ),
        
        'user_demandstatus' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandstatus',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandstatus/index',
            'children' => array(
                'view_demandstatus',
            ),
        ),
        
        'view_demandstatus' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_demandstatus',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_demandstatus' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_demandstatus',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_demandstatus' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_demandstatus',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_demandstatus' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_demandstatus',
            'bizRule' => null,
            'data' => null,
        ),
    );