<?php

class CostCalcWorks extends LSFormModel {
    
    public $ccwk_id;
    public $calc_id;
    public $work_id;
    public $workname;
    public $worknamefull;
    public $cceq_id;
    public $equipname;
    public $unit_name;
    public $quant;
    public $price_low;
    public $price_high;
    public $sum_price_low;
    public $sum_price_high;
    public $note;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_costcalcworks';
        $this->sp_update_name = 'update_costcalcworks';
        $this->sp_delete_name = 'delete_costcalcworks';
        
        $this->proc_params = array(
            'insert_costcalcworks' => array('ccwk_id', 'calc_id', 'cceq_id', 'work_id', 'workname', 'quant', 'price_low', 'price_high', 'note', 'user_create', 'group_id'),
            'update_costcalcworks' => array('ccwk_id', 'calc_id', 'cceq_id', 'work_id', 'workname', 'quant', 'price_low', 'price_high', 'note', 'user_create', 'group_id'),
            'delete_costcalcworks' => array('ccwk_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  ccw.ccwk_id,
                                    ccw.calc_id,
                                    ccw.work_id,
                                    ccw.workname,
                                    IF (ccw.workname is null, w.workname, ccw.workname) as worknamefull,
                                    ccw.cceq_id,
                                    eq.equipname,
                                    u.unit_name,
                                    ccw.quant,
                                    ccw.price_low,
                                    ccw.price_high,
                                    ccw.sum_price_low,
                                    ccw.sum_price_high,
                                    ccw.note,
                                    ccw.date_create,
                                    ccw.user_create,
                                    ccw.date_change,
                                    ccw.user_change,
                                    ccw.group_id,
                                    ccw.deldate";
        $this->command->from = 'costcalcworks ccw left join works w on (ccw.work_id = w.work_id)
                                    left join costcalcequips cce on (ccw.cceq_id = cce.cceq_id)
                                    left join equips eq on (cce.equip_id = eq.equip_id)
                                    left join units u on (eq.unit_id = u.unit_id)';
        $this->command->where = 'ccw.deldate is null';
        $this->command->order = 'ccw.ccwk_id';
                
        $this->filed_id = 'ccwk_id';
        $this->field_id_with_tm = 'e.ccwk_id';
        $this->alias = 'ccw';
    }
    
    public function rules() {
        return array(
            array('calc_id, quant, price_low, price_high', 'required'),
            array('ccwk_id,
                    calc_id,
                    work_id,
                    workname,
                    worknamefull,
                    cceq_id,
                    equipname,
                    unit_name,
                    quant,
                    price_low,
                    price_high,
                    sum_price_low,
                    sum_price_high,
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
            'ccwk_id' => '',
            'calc_id' => '',
            'work_id' => '',
            'workname' => '',
            'worknamefull' => '',
            'cceq_id' => '',
            'equipname' => '',
            'unit_name' => '',
            'quant' => '',
            'price_low' => '',
            'price_high' => '',
            'sum_price_low' => '',
            'sum_price_high' => '',
            'note' => '',
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


