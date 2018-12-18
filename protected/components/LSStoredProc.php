<?php

class LSStoredProc extends CComponent {
    
    public $sp_proc_name;
    
    public $proc_params;
    
    
    public function init() {
        
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
    
    public function execute($params, $fieldsnodef = array()) {
        $sql_init_params = '';
        $sql_call_proc = 'call ' . $this->sp_proc_name . '(';
        $sql_select = 'select ';
        $tmp = array();
        
        $i = 1;
        foreach ($this->proc_params as $key => $value) {
            $sql_init_params .= 'set @' . $value . ' = :p_' . $value . ';';
            if ($i == count($this->proc_params)) {
                $sql_call_proc .= '@' . $value . ');';
                $sql_select .= '@' . $value . ' as ' . $value;
            }
            else {
                $sql_call_proc .= '@' . $value . ',';
                $sql_select .= '@' . $value . ' as ' . $value . ',';
            }
            
            if ($value == 'group_id')
                $tmp[':p_' . $value] = Yii::app()->user->group_id;
            else if ($value == 'user_create' || $value == 'user_change')
                $tmp[':p_' . $value] = Yii::app()->user->user_id;
            else if (isset($params[$value])) {
                if ($params[$value] == '')
                    $tmp[':p_' . $value] = null;
                else if ($params[$value] == 'true')
                    $tmp[':p_' . $value] = 1;
                else if ($params[$value] == 'false')
                    $tmp[':p_' . $value] = 0;
                else {
                    if (array_search($value, $fieldsnodef) !== false)
                        $tmp[':p_' . $value] = $this->datetime_convert($params[$value], 'yyyy-MM-dd HH:mm:ss');
                    else
                        $tmp[':p_' . $value] = htmlspecialchars(htmlentities($this->datetime_convert ($params[$value], 'yyyy-MM-dd HH:mm:ss'), ENT_NOQUOTES, "UTF-8"), ENT_NOQUOTES);
                }
//                    $tmp[':p_' . $value] = htmlspecialchars($this->datetime_convert($params[$value], 'yyyy-MM-dd HH:mm:ss'), ENT_NOQUOTES);
            }
            else
                $tmp[':p_' . $value] = null;
            $i++;
        }
        
        $command = Yii::app()->db->createCommand();
        $command->text = $sql_init_params; //. $sql_call_proc;
        $command->bindValues($tmp);
        $command->execute();
        $command->text = $sql_call_proc;
        $command->execute();
        $command->text = $sql_select;
        return array('tmp' => $tmp, 'sql' => $sql_init_params . $sql_call_proc . $sql_select, 'data' => $command->queryRow());
          
    }
}

