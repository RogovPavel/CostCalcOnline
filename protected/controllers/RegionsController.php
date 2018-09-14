<?php

class RegionsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index'), 'roles'=>array('view_regions'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_user'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_user'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_user'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
}

