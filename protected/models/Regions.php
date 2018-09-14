<?php

class Regions extends LSFormModel {
    
    public $region_id;
    public $region_name;
    public $date_create;
    public $user_create;
    public $surname;
    public $date_change;
    public $user_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->command->select = "r.region_id,
                                    r.region_name,
                                    r.date_create,
                                    r.user_create,
                                    u.surname,
                                    r.date_change,
                                    r.user_change,
                                    r.group_id";
        $this->command->from = 'regions r left join users u on (r.user_create = u.user_id)';
        $this->command->where = 'r.deldate is null';
        $this->command->order = 'r.region_name';
        
                
        $this->filed_id = 'region_id';
        $this->field_id_with_tm = 'r.region_id';
        $this->alias = 'r.';
    }
    
    public function rules() {
        return array(
            array('region_id,
                    region_name,
                    date_create,
                    user_create,
                    surname,
                    date_change,
                    user_change,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'region_id' => '',
            'region_name' => 'Наименование',
            'date_create' => '',
            'user_create' => '',
            'surname' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
        );
    }
}


