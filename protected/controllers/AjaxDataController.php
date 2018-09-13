<?php 

class AjaxDataController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow',
                    'actions'=>array('DataJQXSimple'),
                    'users'=>array('*'),
            ),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function actionDataJQXSimple() {
        
        $modelname = '';
        if (isset($_POST['ModelName']))
            $modelname = $_POST['ModelName'];
        if (isset($_POST['ModelName']))
            $modelname = $_POST['ModelName'];
        
        $model = new $modelname();
//        
//        $res = $model->command->queryAll();
//        $count = count($res);
//        
//        $data = array();
//        
//        $data[] = array(
//            'TotalRows' => $count,
//            'Rows' => $res
//        );
//        
//        echo json_encode($data);
        
        echo '11';
        return;
    }
}

