<?php

class EquipsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index'), 'roles'=>array('view_equips'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_equips'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_equips'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_equips'),),
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
            'error' => '',
            'out' => array(),
        );
        
        try {
            $model = new Equips();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['equips'])) {
                $model->setAttributes($_POST['equips']);
                if ($model->validate()) {
                    
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['out'] = $res;
                    $result['id'] = $res['data']['equip_id'];
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
            $model = new Equips();
            
            if (isset($_POST['equip_id']))
                $model->get_by_id($_POST['equip_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['equips'])) {
                $model->setAttributes($_POST['equips']);
                if ($model->validate()) {
                    
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['out'] = $res;
                    $result['id'] = $res['data']['equip_id'];
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
            $model = new Equips();
            
            if (isset($_POST['equip_id'])) {
                $model->get_by_id($_POST['equip_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['out'] = $res;
                $result['id'] = $res['data']['equip_id'];
                
            }
            
        
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['error'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

