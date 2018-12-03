<?php

class ClientPositions extends LSFormModel {
    
    public $position_id;
    public $positionname;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_clientpositions';
        $this->sp_update_name = 'update_clientpositions';
        $this->sp_delete_name = 'delete_clientpositions';
        
        $this->proc_params = array(
            'insert_clientpositions' => array('position_id', 'positionname', 'user_create', 'group_id'),
            'update_clientpositions' => array('position_id', 'positionname', 'user_change', 'group_id'),
            'delete_clientpositions' => array('position_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "cp.position_id,
                                    cp.positionname,
                                    cp.date_create,
                                    cp.user_create,
                                    cp.date_change,
                                    cp.user_change,
                                    cp.group_id,
                                    cp.deldate";
        $this->command->from = "clientpositions cp";
        $this->command->where = 'cp.deldate is null';
        $this->command->order = 'cp.positionname';
        
                
        $this->filed_id = 'position_id';
        $this->field_id_with_tm = 'cp.position_id';
        $this->alias = 'cp.';
    }
    
    public function rules() {
        return array(
            array('positionname', 'required'),
            array('position_id,
                    positionname,
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
            'positionname' => 'Должность',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


