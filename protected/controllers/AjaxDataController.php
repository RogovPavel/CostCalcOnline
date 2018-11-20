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
                    'actions'=>array('DataJQXSimple', 'DataJQXSimpleList'),
                    'users'=>array('@'),
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
        if (isset($_GET['ModelName']))
            $modelname = $_GET['ModelName'];
        
        $model = new $modelname();
        
        $filters = array();
        if (isset($_POST['filters']))
            $filters = $_POST['filters'];
        if (isset($_GET['filters']))
            $filters = $_POST['filters'];
        
        $i = 0;
        $conditions = array();
        foreach ($filters as $key => $value) {
            $operand = ' = ';
            if ((int)$value['operand'] ==1)
                $operand = ' = ';
            if ((int)$value['operand'] == 2)
                $operand = ' != ';
            if ((int)$value['operand'] == 3)
                $operand = ' > ';
            if ((int)$value['operand'] == 4)
                $operand = ' < ';
            
            array_push($conditions, array('sql' => $value['field'] . $operand . ':p' . $i, 'params' => array(':p' . $i => $value['value'])));
            $i++;
        };
        
        
        $res = $model->find($conditions);
        $count = count($res);
        
        $data = array();
        
        $data[] = array(
            'TotalRows' => $count,
            'Rows' => $res
        );
        
        echo json_encode($data);
        return;
    }
    
    public function actionDataJQXSimpleList() {
        
        $models = array();
        $data = array();
        
        if (isset($_POST['Models']))
            $models = $_POST['Models'];
        if (isset($_GET['Models']))
            $models = $_GET['Models'];
        
        
        foreach ($models as $key => $value) {
        
            $tmp = new $value();
            $res = $tmp->command->queryAll();
            array_push($data, $res);
        }
        
        echo json_encode($data);
        return;
    }
}

