<?php

class ProfileController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow',
                    'actions'=>array('index'),
                    'roles'=>array('view_profile'),
            ),
            array('allow', 
                    'actions'=>array('create'),
                    'roles'=>array('create_user'),
            ),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $model = new Users();
        
        $model->get_by_id(Yii::app()->user->user_id);

        $groupsettings = new GroupSettings();
        $groupsettings->get_by_conditions(array(array(
            'sql' => 's.group_id = :p_group_id',
            'params' => array(':p_group_id' => Yii::app()->user->group_id),
        )));        
        
        $this->render('index', array(
            'model' => $model,
            'groupsettings' => $groupsettings
        ));
    }
}

