<?php

class TemplatesController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index'), 'roles'=>array('view_templates'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_templates'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_templates'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_templates'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionCreate() {
        $model = new Templates();
        $closewindow = false;
        
        
        
        if (isset($_POST['params']))
            $model->setAttributes($_POST['params']);

        if (isset($_POST['templates'])) {
            $model->setAttributes($_POST['templates']);
            if ($model->validate()) {
                $model->user_create = Yii::app()->user->user_id;
                $res = $model->insert();
                $result['id'] = $res['data']['template_id'];
                $closewindow = true;
            }
        }

        $this->render('_form', array(
            'model' => $model,
            'closewindow' => $closewindow
        ));
    }
    
    public function actionUpdate() {
        $model = new Templates();
        $closewindow = false;
        
        if (isset($_GET['id']))
            $model->get_by_id($_GET['id']);
        
        if (isset($_POST['params']))
            $model->setAttributes($_POST['params']);

        if (isset($_POST['templates'])) {
            $model->setAttributes($_POST['templates']);
            if ($model->validate()) {
                $model->user_create = Yii::app()->user->user_id;
                $res = $model->update();
                $result['id'] = $res['data']['template_id'];
                $closewindow = false;
            }
        }

        $this->render('_form', array(
            'model' => $model,
            'closewindow' => $closewindow
        ));
    }
    
    public function actionDelete() {
        $result = array(
            'state' => 0,
            'header' => 'Удаление записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new Templates();
            
            if (isset($_POST['template_id'])) {
                $model->get_by_id($_POST['template_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['template_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 1;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

