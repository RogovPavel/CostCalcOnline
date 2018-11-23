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
                    'actions'=>array('DataJQXSimple', 'DataJQXSimpleList', 'DataJQX'),
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
            $res = $tmp->find();
            array_push($data, $res);
        }
        
        echo json_encode($data);
        return;
    }
    
    public function GetJQXFilters($model) {
        $filters = array(
            'filters' => array(),
            'sql' => '',
            'params' => array()
        );
        
        $filters['filters'] = array_merge($_POST, $_GET);
        
        if (isset($filters['filters']['filterscount'])) {
            
            $filterscount = $filters['filters']['filterscount'];
            
            if ($filterscount > 0) {
                $filters['sql'] = "(";
                $tmpdatafield = "";
                $tmpfilteroperator = "";
                for ($i=0; $i < $filterscount; $i++) {
                    $filtervalue = $filters['filters']["filtervalue" . $i];
                    $filtercondition = $filters['filters']["filtercondition" . $i];
                    $filterdatafield = $model->getattributeforfilters($filters['filters']["filterdatafield" . $i]);
                    $filteroperator = $filters['filters']["filteroperator" . $i];

                    if ($tmpdatafield == "") 
                        $tmpdatafield = $filterdatafield;			
                    else if ($tmpdatafield <> $filterdatafield)
                        $filters['sql'] .= ")AND(";
                    else if ($tmpdatafield == $filterdatafield) {
                        if ($tmpfilteroperator == 0) {
                                $filters['sql'] .= " AND ";
                        }
                        else $filters['sql'] .= " OR ";	
                    }

                    switch($filtercondition) {
                        case "CONTAINS":
                                $filters['params'][':p' . $i] = "%" . $filtervalue . "%";
                                $filters['sql'] .= " " . $filterdatafield . " LIKE " . ":p" . $i;
                                break;
                        case "DOES_NOT_CONTAIN":
                                $filters['params'][':p' . $i] = "%" . $filtervalue . "%";
                                $filters['sql'] .= " " . $filterdatafield . " NOT LIKE " . ":p" . $i;
                                break;
                        case "EQUAL":
                                $filters['params'][':p' . $i] = $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " = " . ":p" . $i;
                                break;
                        case "NOT_EQUAL":
                                $filters['params'][':p' . $i] = $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " <> " . ":p" . $i;
                                break;
                        case "GREATER_THAN":
                                $filters['params'][':p' . $i] = $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " > " . ":p" . $i;
                                break;
                        case "LESS_THAN":
                                $filters['params'][':p' . $i] = $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " < " . ":p" . $i;
                                break;
                        case "GREATER_THAN_OR_EQUAL":
                                $filters['params'][':p' . $i] = $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " >= " . ":p" . $i;
                                break;
                        case "LESS_THAN_OR_EQUAL":
                                $filters['params'][':p' . $i] = $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " <= " . ":p" . $i;
                                break;
                        case "STARTS_WITH":
                                $filters['params'][':p' . $i] = $filtervalue . "%";
                                $filters['sql'] .= " " . $filterdatafield . " LIKE " . ":p" . $i;
                                break;
                        case "ENDS_WITH":
                                $filters['params'][':p' . $i] = "%" . $filtervalue;
                                $filters['sql'] .= " " . $filterdatafield . " LIKE " . ":p" . $i;
                                break;
                        case "NULL":
                                $filters['sql'] .= " " . $filterdatafield . " is Null";
                                break;
                        case "NOT_NULL":
                                $filters['sql'] .= " " . $filterdatafield . " is not Null";
                                break;
                    }

                    if ($i == $filterscount - 1)
                        $filters['sql'] .= ")";

                    $tmpfilteroperator = $filteroperator;
                    $tmpdatafield = $filterdatafield;			
                }

            }
	}
        
        return $filters;
    }
    
    public function GetJQXSort() {
        $sort = '';
        if (isset($_GET['sortdatafield'])) {
            $sortfield = $_GET['sortdatafield'];
            $sortorder = $_GET['sortorder'];
            
            if ($sortfield != NULL) {
                if ($sortorder == "desc") 
                    $sort = $sortfield . ' desc';
                else if ($sortorder == "asc") 
                    $sort = $sortfield . ' asc';
            }
	}
        
        if (isset($_POST['sortdatafield'])) {
            $sortfield = $_POST['sortdatafield'];
            $sortorder = $_POST['sortorder'];
            
            if ($sortfield != NULL) {
                if ($sortorder == "desc") 
                    $sort = $sortfield . ' desc';
                else if ($sortorder == "asc") 
                    $sort = $sortfield . ' asc';
            }
	}
        
        return $sort;
    }
    
    public function actionDataJQX() {
        $modelname = '';
        if (isset($_POST['ModelName']))
            $modelname = $_POST['ModelName'];
        if (isset($_GET['ModelName']))
            $modelname = $_GET['ModelName'];
        
        $model = new $modelname();
        
        $command = Yii::app()->db->createCommand();
        
        $res = array();
        
        if (isset($_GET['pagenum']))
            $pagenum = $_GET['pagenum'];
        if (isset($_GET['pagenum']))
            $pagenum = $_GET['pagenum'];
        
        if (isset($_POST['pagesize']))
            $pagesize = $_POST['pagesize'];
        if (isset($_POST['pagenum']))
            $pagenum = $_POST['pagenum'];
        
	$start = $pagenum * $pagesize;
        
        $filters = $this->GetJQXFilters($model);
        
        $command->select = 'count(*) as quant';
        $command->from = $model->command->from;
        $command->where = $model->command->where;
        
        if ($filters['sql'] != '')
            $command->andWhere($filters['sql'], $filters['params']);
        
        $rowquant = $command->queryRow();

        
        if ($filters['sql'] != '')
            $model->command->andWhere($filters['sql'], $filters['params']);
        
        // сортировка
        $sort = $this->GetJQXSort();
        
        if ($sort != '')
            $model->command->order = $sort;
        
        $model->command->offset = $start;
        $model->command->limit = $pagesize;
        
//        $rows = $model->command->queryAll();
        $rows = $model->find();
        
        $Data[] = array(
            'TotalRows' => $rowquant['quant'],
            'Rows' => $rows,
            'filter' => $filters,
            'sql' => $model->command->text,
        );
        
        echo json_encode($Data);
    }
}

