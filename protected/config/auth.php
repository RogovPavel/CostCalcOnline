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
        
        /* Заявки */
        include(dirname(__FILE__).'/security/demands.php'),   
        /* Ход работы */
        include(dirname(__FILE__).'/security/demandcomments.php'),
            
        /* Сметы */
        include(dirname(__FILE__).'/security/costcalculations.php'),   
        /* Оборудование в сметах */
        include(dirname(__FILE__).'/security/costcalcequips.php'),
        /* Работы в сметах */
        include(dirname(__FILE__).'/security/costcalcworks.php'),
            
        /* Настройки */
        include(dirname(__FILE__).'/security/groupsettings.php'),
            
        /* Должности контактных лиц */
        include(dirname(__FILE__).'/security/clientpositions.php'),
            
        /* Шаблоны документов */
        include(dirname(__FILE__).'/security/templates.php'),
            
        /* Оплаты по смете */
        include(dirname(__FILE__).'/security/costcalcpayments.php'),
            
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
                    
                    'admin_demands',
                    'admin_demandcomments',
                    
                    'admin_costcalculations',
                    'admin_costcalcequips',
                    'admin_costcalcworks',
                    
                    'admin_groupsettings',
                    'admin_clientpositions',
                    'admin_templates',
                    'admin_costcalcpayments',
                ),
            ),
            
            'AdministratorDB' => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Admin',
                'bizRule' => null,
                'data' => null,
                'children' => array(
                    'admin_profile',
                    'admin_groupsettings',
                    
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
                    'admin_objectworks',
                    
                    'admin_demands',
                    'admin_demandcomments',
                    
                    'admin_costcalculations',
                    'admin_costcalcequips',
                    'admin_costcalcworks',
                    
                    'admin_clientpositions',
                    'admin_templates',
                    'admin_costcalcpayments'
                ),
            ),
            
            'Manager' => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Admin',
                'bizRule' => null,
                'data' => null,
                'children' => array(
                    'manager_users',
                    'manager_regions',
                    'manager_firms',
                    'manager_clients',
                    'manager_banks',
                    'manager_streets',
                    'manager_streettypes',
                    'manager_demandtypes',
                    'manager_demandpriors',
                    'manager_objectgroups',
                    'manager_objectgroupcontacts',
                    'manager_objects',
                    'manager_units',
                    'manager_equips',
                    'manager_objectequips',
                    
                    'manager_demands',
                    'manager_demandcomments',
                    
                    'manager_costcalculations',
                    'manager_costcalcequips',
                    'manager_costcalcworks',
                    
                    
                    'manager_clientpositions',
                    'user_costcalcpayments'
                ),
            ),
            
        )
    );
