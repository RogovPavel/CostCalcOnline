<?php

class UsersController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index'), 'roles'=>array('view_users'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_users'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_users'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_users'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionCreate() {
        $result = array(
            'state' => 0,
            'header' => 'Вставка записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new Users();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['users'])) {
                $model->setAttributes($_POST['users']);
                if ($model->validate()) {
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['id'] = $res['data']['user_id'];
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
            $model = new Users();
            
            if (isset($_POST['user_id']))
                $model->get_by_id($_POST['user_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['users'])) {
                $model->setAttributes($_POST['users']);
                if ($model->validate()) {
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['id'] = $res['data']['user_id'];
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
            $model = new Users();
            
            if (isset($_POST['user_id'])) {
                $model->get_by_id($_POST['user_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['user_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 1;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

