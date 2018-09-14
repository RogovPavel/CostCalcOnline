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
    
    public function actionCreate() {
        $result = array(
            'state' => 0,
            'content' => '',
            'dialog_header' => 'Вставка записи',
            'id' => 0,
            'error_type' => '',
            'error_text' => '',
        );
        
        try {
            throw new Exception('Division by zero.');
            
            $model = new Regions();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);


            $result['content'] = $this->renderPartial('_form', array(
                'model' => $model,
            ), true);
        
        } catch (Exception $e) {
            $result['state'] = 1;
            $result['error_type'] = Yii::app()->errorManager->get_error_type(1);
            $result['error_text'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
        
    }
}

