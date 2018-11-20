<?php

class ObjectEquips extends LSFormModel {
    
    public $objeq_id;
    public $object_id;
    public $objectgr_id;
    public $equip_id;
    public $equipname;
    public $unit_name;
    public $quant;
    public $install;
    public $note;
    public $user_create;
    public $date_create;
    public $user_change;
    public $date_change;
    public $deldate;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_objectequips';
        $this->sp_update_name = 'update_objectequips';
        $this->sp_delete_name = 'delete_objectequips';
        
        $this->proc_params = array(
            'insert_objectequips' => array('objeq_id', 'object_id', 'objectgr_id', 'equip_id', 'quant', 'install', 'note', 'user_create', 'group_id'),
            'update_objectequips' => array('objeq_id', 'object_id', 'objectgr_id', 'equip_id', 'quant', 'install', 'note', 'user_change', 'group_id'),
            'delete_objectequips' => array('objeq_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  oe.objeq_id,
                                    oe.object_id,
                                    oe.objectgr_id,
                                    oe.equip_id,
                                    e.equipname,
                                    u.unit_name,
                                    oe.quant,
                                    oe.install,
                                    oe.note,
                                    oe.user_create,
                                    oe.date_create,
                                    oe.user_change,
                                    oe.date_change,
                                    oe.deldate,
                                    oe.group_id";
        $this->command->from = 'objectequips oe left join equips e on (oe.equip_id = e.equip_id)
                                    left join units u on (e.unit_id = u.unit_id)';
        $this->command->where = 'oe.deldate is null';
        $this->command->order = 'oe.objeq_id';
        
                
        $this->filed_id = 'objeq_id';
        $this->field_id_with_tm = 'oe.objeq_id';
        $this->alias = 'oe';
    }
    
    public function rules() {
        return array(
            array('object_id, equip_id, quant', 'required'),
            array('objeq_id,
                    object_id,
                    objectgr_id,
                    equip_id,
                    quant,
                    install,
                    note,
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
            'objeq_id' => '',
            'object_id' => '',
            'objectgr_id' => '',
            'equip_id' => '',
            'quant' => '',
            'install' => '',
            'note' => '',
            'user_create' => '',
            'date_create' => '',
            'user_change' => '',
            'date_change' => '',
            'deldate' => '',
            'group_id' => '',
        );
    }
}


