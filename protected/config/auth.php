<?php
    return array_merge(
        /* Личный кабинет*/
        include(dirname(__FILE__).'/security/profile.php'),
        
        /* Пользователи */
        include(dirname(__FILE__).'/security/users.php'),
        /* Регионы */
        include(dirname(__FILE__).'/security/regions.php'),
        /* Банки */
        include(dirname(__FILE__).'/security/banks.php'),
        /* Клиенты */
        include(dirname(__FILE__).'/security/clients.php'),
        /* Приоритеты заявок */
        include(dirname(__FILE__).'/security/demandpriors.php'),
        /* Статусы заявок */
        include(dirname(__FILE__).'/security/demandstatus.php'),
        /* Типы заявок */
        include(dirname(__FILE__).'/security/demandtypes.php'),
        /* Оборудование */
        include(dirname(__FILE__).'/security/equips.php'),
        /* Фирмы */
        include(dirname(__FILE__).'/security/firms.php'),
        /* Должности */
        include(dirname(__FILE__).'/security/positions.php'),
        /* Роли */
        include(dirname(__FILE__).'/security/roles.php'),
        /* Улицы */
        include(dirname(__FILE__).'/security/streets.php'),
        /* Типы улиц */
        include(dirname(__FILE__).'/security/streettypes.php'),
        /* Тарифы */
        include(dirname(__FILE__).'/security/tariffs.php'),
        /* Ед. изм. */
        include(dirname(__FILE__).'/security/units.php'),
        /* Работы */
        include(dirname(__FILE__).'/security/works.php'),
            
        /* Дома */
        include(dirname(__FILE__).'/security/objectgroups.php'),
        /* Подъезды/Помещения */
        include(dirname(__FILE__).'/security/objects.php'),
        /* Оборудование на подъездах */
        include(dirname(__FILE__).'/security/objectequips.php'),
        /* Контакты */
        include(dirname(__FILE__).'/security/objectgroupcontacts.php'),   
        
            
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
                    
                    'admin_users',
                    'admin_regions',
                    'admin_firms',
                    'admin_clients',
                    'admin_banks',
                    'admin_streets',
                    'admin_streettypes',
                    'admin_demandtypes',
                    'admin_demandpriors',
                    'admin_objectgroups',
                    'admin_objectgroupcontacts',
                    'admin_objects',
                    'admin_units',
                    'admin_equips',
                    'admin_objectequips',
                ),
            ),
        )
    );