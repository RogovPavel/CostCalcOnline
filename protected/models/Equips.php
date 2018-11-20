<?php

class Equips extends LSFormModel {
    
    public $equip_id;
    public $equipname;
    public $unit_id;
    public $unit_name;
    public $note;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_equips';
        $this->sp_update_name = 'update_equips';
        $this->sp_delete_name = 'delete_equips';
        
        $this->proc_params = array(
            'insert_equips' => array('equip_id', 'equipname', 'unit_id', 'note', 'user_create', 'group_id'),
            'update_equips' => array('equip_id', 'equipname', 'unit_id', 'note', 'user_change', 'group_id'),
            'delete_equips' => array('equip_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "e.equip_id,
                                    e.equipname,
                                    e.unit_id,
                                    un.unit_name,
                                    e.note,
                                    e.date_create,
                                    e.user_create,
                                    e.date_change,
                                    e.user_change,
                                    e.group_id,
                                    e.deldate";
        $this->command->from = "equips e left join units un on (e.unit_id = un.unit_id)
                                    left join users u on (e.user_create = u.user_id)";
        $this->command->where = 'e.deldate is null';
        $this->command->order = 'e.equipname';
        
                
        $this->filed_id = 'equip_id';
        $this->field_id_with_tm = 'e.equip_id';
        $this->alias = 'e.';
    }
    
    public function rules() {
        return array(
            array('equipname, unit_id', 'required'),
            array('equip_id,
                    equipname,
                    unit_id,
                    note,
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
            'equip_id' => '',
            'equipname' => 'Оборудование',
            'unit_id' => 'Ед. изм.',
            'note' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


