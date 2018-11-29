<?php

    return array(
        'admin_settings' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'settings',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'settings/index',
            'children' => array(
                'view_settings',
                'create_settings',
                'update_settings',
                'delete_settings',
            ),
        ),
        
        'manager_settings' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'settings',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'settings/index',
            'children' => array(
                'view_settings',
                'create_settings',
                'update_settings',
            ),
        ),
        
        'user_settings' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'settings',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'settings/index',
            'children' => array(
                'view_settings',
            ),
        ),
        
        'view_settings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_settings',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_settings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_settings',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_settings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_settings',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_settings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_settings',
            'bizRule' => null,
            'data' => null,
        ),
    );