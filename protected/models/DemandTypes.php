<?php

class DemandTypes extends LSFormModel {
    
    public $demandtype_id;
    public $demandtype_name;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_demandtypes';
        $this->sp_update_name = 'update_demandtypes';
        $this->sp_delete_name = 'delete_demandtypes';
        
        $this->proc_params = array(
            'insert_demandtypes' => array('demandtype_id', 'demandtype_name', 'user_create', 'group_id'),
            'update_demandtypes' => array('demandtype_id', 'demandtype_name', 'user_change', 'group_id'),
            'delete_demandtypes' => array('demandtype_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "dt.demandtype_id,
                                    dt.demandtype_name,
                                    dt.date_create,
                                    dt.user_create,
                                    dt.date_change,
                                    dt.user_change,
                                    dt.group_id,
                                    dt.deldate";
        $this->command->from = "demandtypes dt left join users u on (dt.user_create = u.user_id)";
        $this->command->where = 'dt.deldate is null';
        $this->command->order = 'dt.demandtype_name';
        
                
        $this->filed_id = 'demandtype_id';
        $this->field_id_with_tm = 'dt.demandtype_id';
        $this->alias = 'dt.';
    }
    
    public function rules() {
        return array(
            array('demandtype_name', 'required'),
            array('demandtype_id,
                    demandtype_name,
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
            'demandtype_id' => '',
            'demandtype_name' => 'Тип заявки',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


