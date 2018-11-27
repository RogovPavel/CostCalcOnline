<?php 

class AjaxDataController extends Controller {
    
    public function filters() {
        return array(
                'accessControl',
        );
    }
    
    public function is_date($date) {
        $type = 0;
        
        $date = str_replace('-', '.', $date);
        
        if (strlen($date) >= 10) {        
            if ($date[2] == '.' && $date[5] == '.')
                $type = 1;
            if ($date[4] == '.' && $date[7] == '.')
                $type = 2;
        }
        
        return $type;
    }
    
    public function datetime_convert($date, $format) {
        $result = '';
        $type = $this->is_date($date);
        
        $d = '';
        $M = '';
        $Y = '';
        
        $H = '00';
        $m = '00';
        $s = '00';
        
        if ($type != 0) {
            if ($type == 1) {
                $d = $date[0] . $date[1];
                $M = $date[3] . $date[4];
                $Y = $date[6] . $date[7] . $date[8] . $date[9];
            }
            
            if ($type == 2) {
                $d = $date[8] . $date[9];
                $M = $date[5] . $date[6];
                $Y = $date[0] . $date[1] . $date[2] . $date[3];
            }
            
            if (strlen($date) > 10) {
                $H = $date[11] . $date[12];
            }
            if (strlen($date) > 13) {
                $m = $date[14] . $date[15];
            }
            if (strlen($date) > 16) {
                $s = $date[17] . $date[18];
            }
            
            $result = str_replace('dd', $d, $format);
            $result = str_replace('MM', $M, $result);
            $result = str_replace('yyyy', $Y, $result);
            $result = str_replace('HH', $H, $result);
            $result = str_replace('mm', $m, $result);
            $result = str_replace('ss', $s, $result);
            
        }
        else
            $result = $date;
        
        return $result;
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
            
            array_push($conditions, array('sql' => $value['field'] . $operand . ':p' . $i, 'params' => array(':p' . $i => $this->datetime_convert ($value['value'], 'yyyy-MM-dd HH:mm:ss'))));
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
                    $filtervalue = $this->datetime_convert($filters['filters']["filtervalue" . $i], 'yyyy-MM-dd HH:mm:ss');
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
        
        $command->andWhere(str_replace('.', '', $model->alias) . '.group_id = :p_group_id', array(':p_group_id' => Yii::app()->user->group_id));
        
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

