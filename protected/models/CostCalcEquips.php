<?php

class CostCalcEquips extends LSFormModel {
    
    public $cceq_id;
    public $calc_id;
    public $equip_id;
    public $equipname;
    public $unit_name;
    public $quant;
    public $price_low;
    public $price_high;
    public $sum_price_low;
    public $sum_price_high;
    public $sum_works_low;
    public $sum_works_high;
    public $note;
    public $sort;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_costcalcequips';
        $this->sp_update_name = 'update_costcalcequips';
        $this->sp_delete_name = 'delete_costcalcequips';
        
        $this->proc_params = array(
            'insert_costcalcequips' => array('cceq_id', 'calc_id', 'equip_id', 'quant', 'price_low', 'price_high', 'note', 'user_create', 'group_id'),
            'update_costcalcequips' => array('cceq_id', 'calc_id', 'equip_id', 'quant', 'price_low', 'price_high', 'note', 'user_change', 'group_id'),
            'delete_costcalcequips' => array('cceq_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  e.cceq_id,
                                    e.calc_id,
                                    e.equip_id,
                                    eq.equipname,
                                    u.unit_name,
                                    e.quant,
                                    e.price_low,
                                    e.price_high,
                                    e.sum_price_low,
                                    e.sum_price_high,
                                    e.sum_works_low,
                                    e.sum_works_high,
                                    e.note,
                                    e.sort,
                                    e.date_create,
                                    e.user_create,
                                    e.date_change,
                                    e.user_change,
                                    e.group_id,
                                    e.deldate";
        $this->command->from = 'costcalcequips e left join equips eq on (e.equip_id = eq.equip_id)
                                    left join units u on (eq.unit_id = u.unit_id)';
        $this->command->where = 'e.deldate is null';
        $this->command->order = 'e.sort';
                
        $this->filed_id = 'cceq_id';
        $this->field_id_with_tm = 'e.cceq_id';
        $this->alias = 'e';
    }
    
    public function rules() {
        return array(
            array('calc_id, equip_id, quant, price_low, price_high', 'required'),
            array('cceq_id,
                    calc_id,
                    equip_id,
                    equipname,
                    unit_name,
                    quant,
                    price_low,
                    price_high,
                    sum_price_low,
                    sum_price_high,
                    sum_works_low,
                    sum_works_high,
                    note,
                    sort,
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
            'cceq_id' => '',
            'calc_id' => '',
            'equip_id' => '',
            'equipname' => '',
            'unit_id' => '',
            'quant' => '',
            'price_low' => '',
            'price_high' => '',
            'sum_price_low' => '',
            'sum_price_high' => '',
            'sum_works_low' => '',
            'sum_works_high' => '',
            'note' => '',
            'sort' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
    
    public function attributeFilters() {
        return array(
            '' => '',
        );
    }
}


