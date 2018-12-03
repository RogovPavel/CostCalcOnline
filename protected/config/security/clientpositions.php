<?php

    return array(
        'admin_clientpositions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'clientpositions',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'clientpositions/index',
            'children' => array(
                'view_clientpositions',
                'create_clientpositions',
                'update_clientpositions',
                'delete_clientpositions',
            ),
        ),
        
        'manager_clientpositions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'clientpositions',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'clientpositions/index',
            'children' => array(
                'view_clientpositions',
                'create_clientpositions',
                'update_clientpositions',
            ),
        ),
        
        'user_clientpositions' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'clientpositions',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'clientpositions/index',
            'children' => array(
                'view_clientpositions',
            ),
        ),
        
        'view_clientpositions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_clientpositions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_clientpositions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_clientpositions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_clientpositions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_clientpositions',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_clientpositions' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_clientpositions',
            'bizRule' => null,
            'data' => null,
        ),
    );