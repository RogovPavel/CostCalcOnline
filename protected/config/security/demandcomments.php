<?php

    return array(
        'admin_demandcomments' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandcomments',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandcomments/index',
            'children' => array(
                'view_demandcomments',
                'create_demandcomments',
                'update_demandcomments',
                'delete_demandcomments',
            ),
        ),
        
        'manager_demandcomments' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandcomments',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandcomments/index',
            'children' => array(
                'view_demandcomments',
                'create_demandcomments',
                'update_demandcomments',
            ),
        ),
        
        'user_demandcomments' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'demandcomments',
            'bizRule' => null,
            'data' => null,
            'defaultIndex' => 'demandcomments/index',
            'children' => array(
                'view_demandcomments',
            ),
        ),
        
        'view_demandcomments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'view_demandcomments',
            'bizRule' => null,
            'data' => null,
        ),
        
        'create_demandcomments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'create_demandcomments',
            'bizRule' => null,
            'data' => null,
        ),
        
        'update_demandcomments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'update_demandcomments',
            'bizRule' => null,
            'data' => null,
        ),
        
        'delete_demandcomments' => array(
            'type' => CAuthItem::TYPE_OPERATION,
            'description' => 'delete_demandcomments',
            'bizRule' => null,
            'data' => null,
        ),
    );