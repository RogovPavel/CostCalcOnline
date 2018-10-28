<?php

    return array(
        'admin_works' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'works',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'works/index',
            'children' => array(
                'view_works',
                'create_works',
                'update_works',
                'delete_works',
            ),
        ),
        
        'manager_works' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'works',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'works/index',
            'children' => array(
                'view_works',
                'create_works',
                'update_works',
            ),
        ),
        
        'user_works' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'works',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'works/index',
            'children' => array(
                'view_works',
            ),
        ),
        
        'view_works' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_works',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_works' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_works',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_works' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_works',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_works' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_works',
            'bizRule' => null,
            'data' => null,
        ),
    );