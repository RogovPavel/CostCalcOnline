<?php

class DemandPriors extends LSFormModel {
    
    public $demandprior_id;
    public $demandprior_name;
    public $time_exec;
    public $worktime;
    public $weekend;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_demandpriors';
        $this->sp_update_name = 'update_demandpriors';
        $this->sp_delete_name = 'delete_demandpriors';
        
        $this->proc_params = array(
            'insert_demandpriors' => array('demandprior_id', 'demandprior_name', 'time_exec', 'worktime', 'weekend', 'user_create', 'group_id'),
            'update_demandpriors' => array('demandprior_id', 'demandprior_name', 'time_exec', 'worktime', 'weekend', 'user_change', 'group_id'),
            'delete_demandpriors' => array('demandprior_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "dp.demandprior_id,
                                    dp.demandprior_name,
                                    dp.time_exec,
                                    dp.worktime,
                                    dp.weekend,
                                    dp.date_create,
                                    dp.user_create,
                                    dp.date_change,
                                    dp.user_change,
                                    dp.group_id,
                                    dp.deldate";
        $this->command->from = "demandpriors dp left join users u on (dp.user_create = u.user_id)";
        $this->command->where = 'dp.deldate is null';
        $this->command->order = 'dp.demandprior_name';
        
                
        $this->filed_id = 'demandprior_id';
        $this->field_id_with_tm = 'dp.demandprior_id';
        $this->alias = 'dp.';
    }
    
    public function rules() {
        return array(
            array('demandprior_name, time_exec, worktime, weekend', 'required'),
            array('demandprior_id,
                    demandprior_name,
                    time_exec,
                    worktime,
                    weekend,
                    date_create,
                    user_create,
                    date_change,
                    user_change,
                    group_id,
                    deldate', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'demandprior_id' => '',
            'demandprior_name' => 'Приоритет',
            'time_exec' => '',
            'worktime' => '',
            'weekend' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


