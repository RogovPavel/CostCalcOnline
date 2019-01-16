<?php

class DemandsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index', 'view', 'getdata'), 'roles'=>array('view_demands'),),
            array('allow', 'actions'=>array('create'), 'roles'=>array('create_demands'),),
            array('allow', 'actions'=>array('update'), 'roles'=>array('update_demands'),),
            array('allow', 'actions'=>array('delete'), 'roles'=>array('delete_demands'),),
            array('allow', 'actions'=>array('send'), 'roles'=>array('send_demands'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionSend() {
        $result = array(
            'state' => 0,
            'header' => 'Вставка записи',
            'id' => 0,
            'responseText' => '',
        );
        
        $sources = array();
        $user_id = null;
        $recipient = null;
        
        try {
            // вычисляем адрес кому отправляем
            if (isset($_POST['user_id'])) {
                $user = new Users();
                $user->get_by_id($_POST['user_id']);

                $user_id = $user->user_id;
                $recipient = $user->work_email;
            }
            
            if ($recipient == null) {
                $result['state'] = 2;
                $result['responseText'] = 'Нет адреса электронной почты получателя.';
                return;
            }
            
            if (isset($_POST['sources'])) {
                $sources = $_POST['sources'];
                $sources = json_decode($sources, true);
            }

            $groupsettings = new GroupSettings();
            $groupsettings->get_by_conditions(array(array(
                'sql' => 's.group_id = :p_group_id',
                'params' => array(':p_group_id' => Yii::app()->user->group_id),
            )));

            $template = new Templates();
            $template->get_by_id($groupsettings->templatefordemands);

            $parser = new LSParserHTML();
            $temp = $parser->fillHTML($sources, $template->template);

            $sender = new LSPHPMailer();

            $sender->host = 'it-pc-02';
            $sender->port = 2155;
            $sender->username = 'reglament';
            $sender->password = 'resetboard';
            $sender->fromaddress = 'reglament@aliton.ru';

            $sender->Send(array($recipient), array(), 'test22', $temp, '', true);
            
            
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionGetData($id) {
        $model = new Demands();
        
        $model->get_by_id($id);
        
        echo json_encode($model);
    }
    
    public function actionView($id) {
        $model = new Demands();
        
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
            $model = new Demands();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['demands'])) {
                $model->setAttributes($_POST['demands']);
                if ($model->validate()) {
                    $model->user_create = Yii::app()->user->user_id;
                    $res = $model->insert();
                    $result['id'] = $res['data']['demand_id'];
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
            $model = new Demands();
            
            if (isset($_POST['demand_id']))
                $model->get_by_id($_POST['demand_id']);

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['demands'])) {
                $model->setAttributes($_POST['demands']);
                if ($model->validate()) {
                    $model->user_change = Yii::app()->user->user_id;
                    $res = $model->update();
                    $result['id'] = $res['data']['demand_id'];
                    return;
                } else {
                    $result['state'] = 1;
                }
                
            }
            $result['responseText'] = $this->renderPartial('_form_update', array(
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
            $model = new Demands();
            
            if (isset($_POST['demand_id'])) {
                $model->get_by_id($_POST['demand_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['demand_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

