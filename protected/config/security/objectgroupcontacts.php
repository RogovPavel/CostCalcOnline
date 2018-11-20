<?php

    return array(
        'admin_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectgroupcontacts/index',
            'children' => array(
                'view_objectgroupcontacts',
                'create_objectgroupcontacts',
                'update_objectgroupcontacts',
                'delete_objectgroupcontacts',
            ),
        ),
        
        'manager_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectgroupcontacts/index',
            'children' => array(
                'view_objectgroupcontacts',
                'create_objectgroupcontacts',
                'update_objectgroupcontacts',
            ),
        ),
        
        'user_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'objectgroupcontacts/index',
            'children' => array(
                'view_objectgroupcontacts',
            ),
        ),
        
        'view_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_objectgroupcontacts' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_objectgroupcontacts',
            'bizRule' => null,
            'data' => null,
        ),
    );