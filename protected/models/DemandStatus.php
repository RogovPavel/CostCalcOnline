<?php

class DemandStatus extends LSFormModel {
    
    public $status_id;
    public $status_name;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_demandstatus';
        $this->sp_update_name = 'update_demandstatus';
        $this->sp_delete_name = 'delete_demandstatus';
        
        $this->proc_params = array(
            'insert_regions' => array('status_id', 'status_name', 'user_create', 'group_id'),
            'update_regions' => array('status_id', 'status_name', 'user_create', 'group_id'),
            'delete_regions' => array('status_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "ds.status_id,
                                    ds.status_name,
                                    ds.date_create,
                                    ds.user_create,
                                    ds.date_change,
                                    ds.user_change,
                                    ds.group_id,
                                    ds.deldate";
        $this->command->from = "demandstatus ds left join users u on (ds.user_create = u.user_id)";
        $this->command->where = 'ds.deldate is null';
        $this->command->order = 'ds.status_name';
        
                
        $this->filed_id = 'status_id';
        $this->field_id_with_tm = 'ds.status_id';
        $this->alias = 'ds.';
    }
    
    public function rules() {
        return array(
            array('status_name', 'required'),
            array('status_id,
                    status_name,
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
            'status_id' => '',
            'status_name' => 'Статус',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


