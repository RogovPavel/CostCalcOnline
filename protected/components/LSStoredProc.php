<?php

class LSStoredProc extends CComponent {
    
    public $sp_proc_name;
    
    public $proc_params;
    
    
    public function init() {
        
    }
    
    public function execute($params) {
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
            else if (isset($params[$value]))
                $tmp[':p_' . $value] = $params[$value];
            else
                $tmp[':p_' . $value] = null;
            $i++;
        }
        
        $command = Yii::app()->db->createCommand();
        $command->text = $sql_init_params . $sql_call_proc;
        $command->bindValues($tmp);
        $command->execute();
        $command->text = $sql_select;
        return array('tmp' => $tmp, 'sql' => $sql_init_params . $sql_call_proc . $sql_select, 'data' => $command->queryRow());
    }
}

