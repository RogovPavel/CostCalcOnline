<?php

class ObjectEquipsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index', 'view', 'getdata'), 'roles'=>array('view_objectgroups'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_objectgroups'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_objectgroups'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_objectgroups'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionGetData($id) {
        $model = new ObjectEquips();
        
        $model->get_by_id($id);
        
        echo json_encode($model);
    }
    
    public function actionView($id) {
        $model = new ObjectEquips();
        
        $model->get_by_id($id);
        
        $this->render('view', array(
            'model' => $model
        ));
    }
    
    public function actionCreate() {
        $result = array(
            'state' => 0,
            'content' => '',
            'dialog_header' => 'Вставка записи',
            'id' => 0,
            'error' => '',
            'out' => array(),
        );
        
        try {
            $model = new ObjectEquips();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['objectequips'])) {
                $model->setAttributes($_POST['objectequips']);
                if ($model->validate()) {
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['out'] = $res;
                    $result['id'] = $res['data']['objeq_id'];
                    return;
                } else {
                    $result['state'] = 1;
                }
                
            }

            $result['content'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
        
    }
    
    public function actionUpdate() {
        $result = array(
            'state' => 0,
            'content' => '',
            'dialog_header' => 'Редактирование записи',
            'id' => 0,
            'error' => '',
            'out' => array(),
        );
        
        try {
            $model = new ObjectEquips();
            
            if (isset($_POST['objeq_id']))
                $model->get_by_id($_POST['objeq_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['objectequips'])) {
                $model->setAttributes($_POST['objectequips']);
                if ($model->validate()) {
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['out'] = $res;
                    $result['id'] = $res['data']['objeq_id'];
                    return;
                } else {
                    $result['state'] = 1;
                }
                
            }
            $result['content'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionDelete() {
        $result = array(
            'state' => 0,
            'content' => '',
            'dialog_header' => 'Удаление записи',
            'id' => 0,
            'error' => '',
            'out' => array(),
        );
        
        try {
            $model = new ObjectEquips();
            
            if (isset($_POST['objeq_id'])) {
                $model->get_by_id($_POST['objeq_id']);
                $model->user_change = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['out'] = $res;
                $result['id'] = $res['data']['objeq_id'];
                
            }
            
        
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

