<?php

    return array(
        'admin_groupsettings' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'groupsettings',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'groupsettings/index',
            'children' => array(
                'view_groupsettings',
                'create_groupsettings',
                'update_groupsettings',
                'delete_groupsettings',
            ),
        ),
        
        'manager_groupsettings' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'groupsettings',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'groupsettings/index',
            'children' => array(
                'view_groupsettings',
                'create_groupsettings',
                'update_groupsettings',
            ),
        ),
        
        'user_groupsettings' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'groupsettings',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'groupsettings/index',
            'children' => array(
                'view_groupsettings',
            ),
        ),
        
        'view_groupsettings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_groupsettings',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_groupsettings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_groupsettings',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_groupsettings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_groupsettings',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_groupsettings' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_groupsettings',
            'bizRule' => null,
            'data' => null,
        ),
    );