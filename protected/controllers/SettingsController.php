<?php

class SettingsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index', 'view', 'getdata'), 'roles'=>array('view_settings'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_settings'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionGetData($id) {
        $model = new Settings();
        
        $model->get_by_id($id);
        
        echo json_encode($model);
    }
    
    public function actionView($id) {
        $model = new Settings();
        
        $model->get_by_id($id);
        
        $this->render('view', array(
            'model' => $model
        ));
    }
    
    public function actionCreate() {
        $result = array(
            'state' => 0,
            'header' => 'Вставка записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new Settings();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['settings'])) {
                $model->setAttributes($_POST['settings']);
                if ($model->validate()) {
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['id'] = $res['data']['setting_id'];
                    return;
                } else {
                    $result['state'] = 1;
                }
            }

            $result['responseText'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
        
    }
    
    public function actionUpdate() {
        $result = array(
            'state' => 0,
            'header' => 'Редактирование записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new Settings();
            $model->user_id = Yii::app()->user->user_id;
                    
            if (isset($_POST['setting_id']))
                $model->get_by_id($_POST['setting_id']);
                
            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['settings'])) {
                $model->setAttributes($_POST['settings']);
                if ($model->validate()) {
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    
                    $_SESSION['theme'] = $model->theme;
                    $this->theme = $model->theme;
                    
                    $result['id'] = $res['data']['setting_id'];
                    return;
                } else {
                    $result['state'] = 1;
                }
                
            }
            $result['responseText'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionDelete() {
        $result = array(
            'state' => 0,
            'header' => 'Удаление записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new Settings();
            
            if (isset($_POST['setting_id'])) {
                $model->get_by_id($_POST['setting_id']);
                $model->user_change = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['setting_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

