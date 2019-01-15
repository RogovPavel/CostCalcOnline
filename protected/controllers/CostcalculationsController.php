<?php

class CostcalculationsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index', 'view', 'getdata'), 'roles'=>array('view_costcalculations')),
            array('allow', 'actions'=>array('create', 'copy'), 'roles'=>array('create_costcalculations')),
            array('allow', 'actions'=>array('update', 'updatedetails', 'ready', 'undo'), 'roles'=>array('update_costcalculations')),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_costcalculations')),
            array('deny', 'users'=>array('*'))
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionGetData($id) {
        $model = new CostCalculations();
        
        $model->get_by_id($id);
        
        echo json_encode($model);
    }
    
    public function actionView($id) {
        $model = new CostCalculations();
        
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
            $model = new CostCalculations();
            
            $model->type = 1;
            
            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['costcalculations'])) {
                $model->setAttributes($_POST['costcalculations']);
                if ($model->validate()) {
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['id'] = $res['data']['calc_id'];
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
            $model = new CostCalculations();
            
            if (isset($_POST['calc_id']))
                $model->get_by_id($_POST['calc_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['costcalculations'])) {
                $model->setAttributes($_POST['costcalculations']);
                if ($model->validate()) {
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['id'] = $res['data']['calc_id'];
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
    
    public function actionUndo() {
        $result = array(
            'state' => 0,
            'header' => 'Редактирование записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $sp = new LSStoredProc();
    
            $sp->sp_proc_name = 'undo_costcalculations';
            $sp->proc_params = array('calc_id', 'user_change', 'group_id');
            
            if (isset($_POST['params'])) {
                $params = array(
                    'calc_id' => $_POST['params']['calc_id'],
                    'user_change' => Yii::app()->user->user_id,
                    'group_id' => Yii::app()->user->group_id
                 );
                
                $res = $sp->execute($params);
                $result['id'] = $res['data']['calc_id'];
            }
            
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionReady() {
        $result = array(
            'state' => 0,
            'header' => 'Редактирование записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $sp = new LSStoredProc();
    
            $sp->sp_proc_name = 'ready_costcalculations';
            $sp->proc_params = array('calc_id', 'user_change', 'group_id');
            
            if (isset($_POST['params'])) {
                $params = array(
                    'calc_id' => $_POST['params']['calc_id'],
                    'user_change' => Yii::app()->user->user_id,
                    'group_id' => Yii::app()->user->group_id
                 );
                
                $res = $sp->execute($params);
                $result['id'] = $res['data']['calc_id'];
            }
            
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionUpdateDetails() {
        $result = array(
            'state' => 0,
            'header' => 'Редактирование записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $model = new CostCalcDetails();
            
            if (isset($_POST['calc_id']))
                $model->get_by_id($_POST['calc_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['costcalcdetails'])) {
                $model->setAttributes($_POST['costcalcdetails']);
                
                if ($model->validate()) {
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['id'] = $res['data']['calc_id'];
                    return;
                } else {
                    $result['state'] = 1;
                }
                
            }
            $result['responseText'] = $this->renderPartial('_form_details', array(
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
            $model = new CostCalculations();
            
            if (isset($_POST['calc_id'])) {
                $model->get_by_id($_POST['calc_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['calc_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionCopy() {
        $result = array(
            'state' => 0,
            'header' => 'Копирование записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            $sp = new LSStoredProc();
    
            $sp->sp_proc_name = 'copy_costcalculations';
            $sp->proc_params = array('calc_id', 'out_calc_id', 'objectgr_id', 'user_create', 'group_id');
            
            if (isset($_POST['params'])) {
                $params = array(
                    'calc_id' => null,
                    'out_calc_id' => $_POST['params']['calc_id'],
                    'objectgr_id' => $_POST['params']['objectgr_id'],
                    'user_create' => Yii::app()->user->user_id,
                    'group_id' => Yii::app()->user->group_id
                 );
                
                $res = $sp->execute($params);
                $result['id'] = $res['data']['calc_id'];
            }
            
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
        } finally {
            echo json_encode($result);
        }
    }
}

