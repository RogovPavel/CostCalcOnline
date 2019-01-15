<?php

if (Yii::app()->user->isGuest) {
    $menu = array(
        'Главная' => array(
            'url' => Yii::app()->createUrl('site'),
            'children' => array(
                'О программе' => array('url' => '', 'visible' => true)
            ),
        ),
        'Вход' => array(
            'url' => Yii::app()->createUrl('site/login'),
        ),
    );
}
else
    $menu = array(
        'Главная' => array(
            'url' => Yii::app()->createUrl('site'),
            'children' => array(
                'Админка' => array('url' => Yii::app()->createUrl('profile'), 'visible' => Yii::app()->user->checkAccess('view_profile')),
                'О программе' => array('url' => '', 'visible' => true)
            ),
        ),
        'Справочники' => array(
            'children' => array(
                'Адреса' => array('children' => array(
                    'Регионы' => array('url' => Yii::app()->createUrl('regions'), 'visible' => Yii::app()->user->checkAccess('view_regions')),
                    'Типы улиц' => array('url' => Yii::app()->createUrl('streettypes'), 'visible' => Yii::app()->user->checkAccess('view_streettypes')),
                    'Улицы' => array('url' => Yii::app()->createUrl('streets'), 'visible' => Yii::app()->user->checkAccess('view_streets')),
                )),
                'Организации' => array('children' => array(
                    'Банки' => array('url' => Yii::app()->createUrl('banks'), 'visible' => Yii::app()->user->checkAccess('view_banks')),
                    'Мои организации' => array('url' => Yii::app()->createUrl('firms'), 'visible' => Yii::app()->user->checkAccess('view_firms')),
                    'Клиенты' => array('url' => Yii::app()->createUrl('clients'), 'visible' => Yii::app()->user->checkAccess('view_clients')),
                    'Должности' => array('url' => Yii::app()->createUrl('clientpositions'), 'visible' => Yii::app()->user->checkAccess('view_clientpositions')),
                )),
                'Заявки' => array('children' => array(
                    'Типы' => array('url' => Yii::app()->createUrl('demandtypes'), 'visible' => Yii::app()->user->checkAccess('view_demandtypes')),
                    'Приоритеты' => array('url' => Yii::app()->createUrl('demandpriors'), 'visible' => Yii::app()->user->checkAccess('view_demandpriors')),
                )),
                'Оборудование' => array('children' => array(
                    'Ед. измерения' => array('url' => Yii::app()->createUrl('units'), 'visible' => Yii::app()->user->checkAccess('view_units')),
                    'Оборудование' => array('url' => Yii::app()->createUrl('equips'), 'visible' => Yii::app()->user->checkAccess('view_equips')),
                )),
            ),
        ),
        'Реестры' => array(
            'children' => array(
                'Реестр объектов' => array('url' => Yii::app()->createUrl('objectgroups'), 'visible' => Yii::app()->user->checkAccess('view_objectgroups')),
                'Реестр заявок' => array('url' => Yii::app()->createUrl('demands'), 'visible' => Yii::app()->user->checkAccess('view_demands')),
                'Реестр смет' => array('url' => Yii::app()->createUrl('costcalculations'), 'visible' => Yii::app()->user->checkAccess('view_costcalculations')),
            ),
        ),
        'Вход' => array(
            'url' => 'site/login',
            'visible' => (Yii::app()->user->isGuest)
        ),
        'Выход' => array(
            'url' => 'site/logout',
            'visible' => (!Yii::app()->user->isGuest)
        ),
    );

global $menustr;

function recursion ($menu) {
    foreach ($menu as $key => $value) {
        if (is_numeric($key))
            $GLOBALS['menustr'] .= '<li><a href="">' . $value . '</a></li>';
        else {
            $visible = true;
            if (isset($value['visible'])) 
                $visible = $value['visible'];
            
            $url = '';
            if (isset($value['url'])) 
                $url = $value['url'];
                        
            if ($visible == true) {
                $GLOBALS['menustr'] .= '<li><a href="' . $url . '">' . $key . '</a>';

                if (isset($value['children'])) {
                    $GLOBALS['menustr'] .= '<ul>';
                    recursion($value['children']);
                    $GLOBALS['menustr'] .= '</ul>';
                }
                $GLOBALS['menustr'] .= '</li>';
            }
        }
    }
};

recursion($menu);

return '<ul>' . $menustr . '</ul>';