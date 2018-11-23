<?php

class Objects extends LSFormModel {
    
    public $object_id;
    public $objectgr_id;
    public $doorway;
    public $quant_flats;
    public $code;
    public $address;
    public $note; 
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_objects';
        $this->sp_update_name = 'update_objects';
        $this->sp_delete_name = 'delete_objects';
        
        $this->proc_params = array(
            'insert_objects' => array('object_id', 'objectgr_id', 'doorway', 'quant_flats', 'code', 'note', 'user_create', 'group_id'),
            'update_objects' => array('object_id', 'objectgr_id', 'doorway', 'quant_flats', 'code', 'note', 'user_create', 'group_id'),
            'delete_objects' => array('object_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  o.object_id,
                                    o.objectgr_id,
                                    o.doorway,
                                    o.quant_flats,
                                    o.code,
                                    o.address,
                                    o.note,
                                    o.date_create,
                                    o.user_create,
                                    o.date_change,
                                    o.user_change,
                                    o.group_id";
        $this->command->from = 'objects o';
        $this->command->where = 'o.deldate is null
                    and o.doorway <> \'Общее\'';
        $this->command->order = 'o.object_id';
        
                
        $this->filed_id = 'object_id';
        $this->field_id_with_tm = 'o.object_id';
        $this->alias = 'o';
    }
    
    public function rules() {
        return array(
            array('objectgr_id, doorway', 'required'),
            array('object_id,
                    objectgr_id,
                    doorway,
                    quant_flats,
                    code,
                    address,
                    note,
                    date_create,
                    user_create,
                    date_change,
                    user_change,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'object_id' => '',
            'objectgr_id' => '',
            'doorway' => '',
            'quant_flats' => '',
            'code' => '',
            'address' => '',
            'note' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
        );
    }
}


