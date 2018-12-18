<?php

class Images extends LSFormModel {
    
    public $image_id;
    public $image;
    public $user_create;
    public $date_create;
    public $user_change;
    public $date_change;
    public $deldate;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_images';
        $this->sp_delete_name = 'delete_images';
        
        $this->proc_params = array(
            'insert_images' => array('image_id', 'image', 'user_create', 'group_id'),
            'delete_images' => array('image_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "i.image_id,"
                . "i.image,"
                . "i.user_create,"
                . "i.date_create,"
                . "i.user_change,"
                . "i.date_change,"
                . "i.group_id";
        $this->command->from = 'images i';
        $this->command->where = 'i.deldate is null';
        $this->command->order = 'i.image_id';
        
                
        $this->filed_id = 'image_id';
        $this->field_id_with_tm = 'i.image_id';
        $this->alias = 'i.';
    }
    
    public function rules() {
        return array(
            array('image_id,
                    image,
                    user_create,
                    date_create,
                    user_change,
                    date_change,
                    deldate,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'image_id' => '',
            'image' => '',
            'user_create' => '',
            'date_create' => '',
            'user_change' => '',
            'date_change' => '',
            'deldate' => '',
            'group_id' => '',
        );
    }
}


