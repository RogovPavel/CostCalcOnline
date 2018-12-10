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

        if (isset($_POST['params']))
            $model->setAttributes($_POST['params']);

        if (isset($_POST['templates'])) {
            $model->setAttributes($_POST['templates']);
            if ($model->validate()) {
                $model->user_create = Yii::app()->user->user_id;
                $res = $model->insert();
                $result['id'] = $res['data']['template_id'];
                return;
            } else {
                $result['state'] = 1;
            }

        }

        $this->render('_form', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdate() {
        $result = array(
            'state' => 0,
            'header' => 'Редактирование записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new Templates();
            
            if (isset($_POST['firm_id']))
                $model->get_by_id($_POST['firm_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['templates'])) {
                $model->setAttributes($_POST['templates']);
                if ($model->validate()) {
                    
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['id'] = $res['data']['firm_id'];
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
            $model = new Templates();
            
            if (isset($_POST['firm_id'])) {
                $model->get_by_id($_POST['firm_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['firm_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 1;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

