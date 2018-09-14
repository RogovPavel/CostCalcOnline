<?php

    return array(
        'admin_regions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'managers',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'manager/index',
            'children' => array(
                'view_regions',
                'create_regions',
                'update_regions',
                'delete_regions',
            ),
        ),
        
        'manager_regions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'managers',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'manager/index',
            'children' => array(
                'view_regions',
                'create_regions',
                'update_regions',
            ),
        ),
        
        'user_regions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'managers',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'manager/index',
            'children' => array(
                'view_regions',
            ),
        ),
        
        'view_regions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_regions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_regions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_regions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_regions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_regions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_regions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_regions',
            'bizRule' => null,
            'data' => null,
        ),
    );