<?php

class Positions extends LSFormModel {
    
    public $position_id;
    public $position_name;
    public $position_shortname;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_positions';
        $this->sp_update_name = 'update_positions';
        $this->sp_delete_name = 'delete_positions';
        
        $this->proc_params = array(
            'insert_regions' => array('position_id', 'position_name', 'position_shortname', 'user_create', 'group_id'),
            'update_regions' => array('position_id', 'position_name', 'position_shortname', 'user_change', 'group_id'),
            'delete_regions' => array('position_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "p.position_id,
                                    p.position_name,
                                    p.position_shortname,
                                    p.date_create,
                                    p.user_create,
                                    p.date_change,
                                    p.user_change,
                                    p.group_id,
                                    p.deldate";
        $this->command->from = "positions p left join users u on (p.user_create = u.user_id)";
        $this->command->where = 'p.deldate is null';
        $this->command->order = 'p.position_name';
        
                
        $this->filed_id = 'position_id';
        $this->field_id_with_tm = 'p.position_id';
        $this->alias = 'p.';
    }
    
    public function rules() {
        return array(
            array('position_name, position_shortname', 'required'),
            array('position_id,
                    position_name,
                    position_shortname,
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
            'position_id' => '',
            'position_name' => 'Должность',
            'position_shortname' => 'Аббревиатура',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


