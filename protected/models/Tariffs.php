<?php

class Tariffs extends LSFormModel {
    
    public $tariff_id;
    public $tariff_name;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_tariffs';
        $this->sp_update_name = 'update_tariffs';
        $this->sp_delete_name = 'delete_tariffs';
        
        $this->proc_params = array(
            'insert_regions' => array('tariff_id', 'tariff_name', 'user_create', 'group_id'),
            'update_regions' => array('tariff_id', 'tariff_name', 'user_change', 'group_id'),
            'delete_regions' => array('tariff_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "t.tariff_id,
                                    t.tariff_name,
                                    t.date_create,
                                    t.user_create,
                                    t.date_change,
                                    t.user_change,
                                    t.group_id,
                                    t.deldate";
        $this->command->from = 'tariffs t left join users u on (t.user_create = u.user_id)';
        $this->command->where = 't.deldate is null';
        $this->command->order = 't.tariff_name';
        
                
        $this->filed_id = 'tariff_id';
        $this->field_id_with_tm = 't.tariff_id';
        $this->alias = 't.';
    }
    
    public function rules() {
        return array(
            array('tariff_name', 'required'),
            array('tariff_id,
                    tariff_name,
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
            'tariff_id' => '',
            'tariff_name' => 'Тариф',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


