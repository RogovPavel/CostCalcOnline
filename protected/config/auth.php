<?php
    return array_merge(
        /* Личный кабинет*/
        include(dirname(__FILE__).'/security/profile.php'),
            
        array(    
            'guest' => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Guest',
                'bizRule' => null,
                'data' => null
            ),

            'Admin' => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Admin',
                'bizRule' => null,
                'data' => null,
                'children' => array(
                    'admin_profile',
                ),
            ),
        )
    );