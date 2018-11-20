<?php

class Units extends LSFormModel {
    
    public $unit_id;
    public $unit_name;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_units';
        $this->sp_update_name = 'update_units';
        $this->sp_delete_name = 'delete_units';
        
        $this->proc_params = array(
            'insert_units' => array('unit_id', 'unit_name', 'user_create', 'group_id'),
            'update_units' => array('unit_id', 'unit_name', 'user_change', 'group_id'),
            'delete_units' => array('unit_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "un.unit_id,
                                    un.unit_name,
                                    un.date_create,
                                    un.user_create,
                                    un.date_change,
                                    un.user_change,
                                    un.group_id,
                                    un.deldate";
        $this->command->from = 'units un left join users u on (un.user_create = u.user_id)';
        $this->command->where = 'un.deldate is null';
        $this->command->order = 'un.unit_name';
        
                
        $this->filed_id = 'unit_id';
        $this->field_id_with_tm = 'un.unit_id';
        $this->alias = 'un.';
    }
    
    public function rules() {
        return array(
            array('unit_name', 'required'),
            array('unit_id,
                    unit_name,
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
            'unit_id' => '',
            'unit_name' => 'Ед. изм.',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


