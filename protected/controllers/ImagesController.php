<?php

class ImagesController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
                'postOnly + create, update, delete',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionIndex($id) {
        if ( isset($_GET['id'])) {
            // Здесь $id номер изображения
            $id = (int)$_GET['id'];
            if ( $id > 0 ) {
                $model = new Images();
                // Выполняем запрос и получаем файл
                $model->get_by_id($id);
                
                // Отсылаем браузеру заголовок, сообщающий о том, что сейчас будет передаваться файл изображения
                header("Content-type: image/*");
                // И  передаем сам файл
                echo $model->image;
            }
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
            $model = new Images();
            
            if (isset($_POST['image_id'])) {
                $model->get_by_id($_POST['image_id']);
                $model->user_chnage = Yii::app()->user->user_id;
                $res = $model->delete();
                $result['id'] = $res['data']['image_id'];
            }
        } catch (Exception $e) {
            $result['state'] = 1;
            $result['responseText'] = $e->getMessage();
            
        } finally {
            echo json_encode($result);
        }
    }
}

