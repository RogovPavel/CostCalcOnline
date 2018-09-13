<?php

    return array(
        'admin_profile' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'managers',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'manager/index',
            'children' => array(
                'view_profile',
                'create_user',
                'manager_profile',
            ),
        ),
        
        'manager_profile' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'managers',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'manager/index',
            'children' => array(
                'view_profile',
                'create_user',
            ),
        ),
        
        'view_profile' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_profile',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_user' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_user',
            'bizRule' => null,
            'data' => null,
        ),
    );