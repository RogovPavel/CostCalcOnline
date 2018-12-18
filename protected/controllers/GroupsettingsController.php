<?php

class GroupsettingsController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow', 'actions'=>array('index', 'view', 'getdata'), 'roles'=>array('view_groupsettings'),),
            array('allow', 'actions'=>array('update', 'loadimg'), 'roles'=>array('update_groupsettings'),),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionGetData($id) {
        $model = new GroupSettings();
        
        $model->get_by_id($id);
        
        echo json_encode($model);
    }
    
    public function actionView($id) {
        $model = new GroupSettings();
        
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
            $model = new GroupSettings();

            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['groupsettings'])) {
                $model->setAttributes($_POST['groupsettings']);
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
            $model = new GroupSettings();
            $model->user_id = Yii::app()->user->user_id;
                    
            if (isset($_POST['setting_id']))
                $model->get_by_id($_POST['setting_id']);
                
            if (isset($_POST['params']))
                $model->setAttributes($_POST['params']);
            
            if (isset($_POST['groupsettings'])) {
                $model->setAttributes($_POST['groupsettings']);
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
            $model = new GroupSettings();
            
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
    
    public function actionLoadImg() {
        $result = array(
            'state' => 0,
            'header' => 'Удаление записи',
            'id' => 0,
            'responseText' => '',
        );
        
        try {
            if( !empty( $_FILES['logo']['name'] ) ) {
                // Проверяем, что при загрузке не произошло ошибок
                if ( $_FILES['logo']['error'] == 0 ) {
                    // Если файл загружен успешно, то проверяем - графический ли он
                    if( substr($_FILES['logo']['type'], 0, 5) == 'image' ) {
                      // Читаем содержимое файла
                        
                      $image = file_get_contents($_FILES['logo']['tmp_name']);
                      // Экранируем специальные символы в содержимом файла
                      $image = mysql_escape_string($image);
                    }
                }
            }
            
            $query = "INSERT INTO images (image, user_create, date_create, group_id) VALUES ('".$image."', " . Yii::app()->user->user_id . ", now(), " . Yii::app()->user->group_id . ")";
            $command = Yii::app()->db->createCommand();
            $command->text = $query;
            $command->execute();
            
            $command->text = 'select last_insert_id() as rowid';
            $row = $command->queryRow();
            
            if ((int)$row['rowid'] > 0)  {
                
                $groupsettings = new GroupSettings();
                $groupsettings->get_by_conditions(array(array(
                    'sql' => 's.group_id = :p_group_id',
                    'params' => array(':p_group_id' => Yii::app()->user->group_id)
                )));
                $groupsettings->logo = $row['rowid'];
                $groupsettings->update();
                
                $result['state'] = 0;
                $result['responseText'] = 'Файл успешно загружен';
            }
            
                
            
        } catch (Exception $e) {
            $result['state'] = 2;
            $result['responseText'] = $e->getMessage();
        } finally {
            echo json_encode($result);
        }
    }
            
}

