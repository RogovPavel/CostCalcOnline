<?php

    return array(
        'admin_objectgroups' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectgroups',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectgroups/index',
            'children' => array(
                'view_objectgroups',
                'create_objectgroups',
                'update_objectgroups',
                'delete_objectgroups',
            ),
        ),
        
        'manager_objectgroups' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectgroups',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectgroups/index',
            'children' => array(
                'view_objectgroups',
                'create_objectgroups',
                'update_objectgroups',
            ),
        ),
        
        'user_objectgroups' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectgroups',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectgroups/index',
            'children' => array(
                'view_objectgroups',
            ),
        ),
        
        'view_objectgroups' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_objectgroups',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_objectgroups' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_objectgroups',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_objectgroups' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_objectgroups',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_objectgroups' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_objectgroups',
            'bizRule' => null,
            'data' => null,
        ),
    );