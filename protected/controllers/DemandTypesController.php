<?php

class DemandTypesController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index'), 'roles'=>array('view_demandtypes'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_demandtypes'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_demandtypes'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_demandtypes'),),
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
            'error' => 0,
            'content' => '',
            'dialog_header' => 'Вставка записи',
            'id' => 0,
            'error_type' => '',
            'error_text' => '',
            '_error' => '',
            'out' => array(),
        );
        
        try {
            $model = new DemandTypes();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['demandtypes'])) {
                if ($model->validate()) {
                    $model->setAttributes($_POST['demandtypes']);
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['out'] = $res;
                    $result['id'] = $res['data']['demandtype_id'];
                }
                return;
            }

            $result['content'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['error'] = 1;
            $result['error_type'] = Yii::app()->errorManager->getErrorType(15);
            $result['error_text'] = Yii::app()->errorManager->getErrorMessage(15);
            $result['_error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
        
    }
    
    public function actionUpdate() {
        $result = array(
            'error' => 0,
            'content' => '',
            'dialog_header' => 'Редактирование записи',
            'id' => 0,
            'error_type' => '',
            'error_text' => '',
            '_error' => '',
            'out' => array(),
        );
        
        try {
            $model = new DemandTypes();
            
            if (isset($_POST['demandtype_id']))
                $model->get_by_id($_POST['demandtype_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['demandtypes'])) {
                if ($model->validate()) {
                    $model->setAttributes($_POST['demandtypes']);
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['out'] = $res;
                    $result['id'] = $res['data']['demandtype_id'];
                }
                return;
            }

            $result['content'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['error'] = 1;
            $result['error_type'] = Yii::app()->errorManager->getErrorType(15);
            $result['error_text'] = Yii::app()->errorManager->getErrorMessage(15);
            $result['_error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionDelete() {
        $result = array(
            'error' => 0,
            'content' => '',
            'dialog_header' => 'Удаление записи',
            'id' => 0,
            'error_type' => '',
            'error_text' => '',
            '_error' => '',
            'out' => array(),
        );
        
        try {
            $model = new DemandTypes();
            
            if (isset($_POST['demandtype_id'])) {
                $model->get_by_id($_POST['demandtype_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['out'] = $res;
                $result['id'] = $res['data']['demandtype_id'];
                
            }
            
        
        } catch (Exception $e) {
            $result['error'] = 1;
            $result['error_type'] = Yii::app()->errorManager->getErrorType(30);
            $result['error_text'] = Yii::app()->errorManager->getErrorMessage(30);
            $result['_error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

