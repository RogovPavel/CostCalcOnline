<?php

class Works extends LSFormModel {
    
    public $work_id;
    public $workname;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_works';
        $this->sp_update_name = 'update_works';
        $this->sp_delete_name = 'delete_works';
        
        $this->proc_params = array(
            'insert_regions' => array('work_id', 'workname', 'user_create', 'group_id'),
            'update_regions' => array('work_id', 'workname', 'user_change', 'group_id'),
            'delete_regions' => array('work_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "w.work_id,
                                    w.workname,
                                    w.date_create,
                                    w.user_create,
                                    w.date_change,
                                    w.user_change,
                                    w.group_id,
                                    w.deldate";
        $this->command->from = 'works w left join users u on (w.user_create = u.user_id)';
        $this->command->where = 'w.deldate is null';
        $this->command->order = 'w.workname';
        
                
        $this->filed_id = 'work_id';
        $this->field_id_with_tm = 'w.work_id';
        $this->alias = 'w.';
    }
    
    public function rules() {
        return array(
            array('workname', 'required'),
            array('work_id,
                    workname,
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
            'work_id' => '',
            'workname' => 'Работа',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


