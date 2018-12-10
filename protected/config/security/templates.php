<?php

    return array(
        'admin_templates' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'templates',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'templates/index',
            'children' => array(
                'view_templates',
                'create_templates',
                'update_templates',
                'delete_templates',
            ),
        ),
        
        'manager_templates' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'templates',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'templates/index',
            'children' => array(
                'view_templates',
                'create_templates',
                'update_templates',
            ),
        ),
        
        'user_templates' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'templates',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'templates/index',
            'children' => array(
                'view_templates',
            ),
        ),
        
        'view_templates' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_templates',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_templates' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_templates',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_templates' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_templates',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_templates' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_templates',
            'bizRule' => null,
            'data' => null,
        ),
    );