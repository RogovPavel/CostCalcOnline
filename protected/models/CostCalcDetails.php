<?php

class CostCalcDetails extends LSFormModel {
    
    public $calc_id;
    public $koef;
    public $discount;
    public $sum_materials_low;
    public $sum_materials_high;
    public $sum_startworks_low;
    public $sum_startworks_high;
    public $sum_works_low;
    public $sum_works_high;
    public $sum_equips_low;
    public $sum_equips_high;
    public $sum_expences_low;
    public $sum_expences_high;
    public $sum_low_full;
    public $sum_high_full;
    public $sum_marj;
    public $percent_marj;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = '';
        $this->sp_update_name = 'update_costcalcdetails';
        $this->sp_delete_name = '';
        
        $this->proc_params = array(
            'update_costcalcdetails' => array('calc_id', 'koef', 'discount', 'sum_materials_low', 'sum_materials_high', 'sum_startworks_low', 'sum_startworks_high', 'sum_expences_low', 'sum_expences_high', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  c.calc_id,
                                    c.koef,
                                    c.discount,
                                    c.sum_materials_low,
                                    c.sum_materials_high,
                                    c.sum_startworks_low,
                                    c.sum_startworks_high,
                                    c.sum_works_low,
                                    c.sum_works_high,
                                    c.sum_equips_low,
                                    c.sum_equips_high,
                                    c.sum_expences_low,
                                    c.sum_expences_high,
                                    c.sum_low_full,
                                    c.sum_high_full,
                                    c.sum_marj,
                                    c.percent_marj";
        $this->command->from = "costcalculations c";
        $this->command->where = 'c.deldate is null';
        $this->command->order = 'c.calc_id';
        
                
        $this->filed_id = 'calc_id';
        $this->field_id_with_tm = 'c.calc_id';
        $this->alias = 'c.';
    }
    
    public function rules() {
        return array(
            array('calc_id', 'required'),
            array(' calc_id,
                    koef,
                    discount,
                    sum_materials_low,
                    sum_materials_high,
                    sum_startworks_low,
                    sum_startworks_high,
                    sum_works_low,
                    sum_works_high,
                    sum_equips_low,
                    sum_equips_high,
                    sum_expences_low,
                    sum_expences_high,
                    sum_low_full,
                    sum_high_full,
                    sum_marj,
                    percent_marj', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'calc_id' => '',
            'koef' => '',
            'discount' => '',
            'sum_materials_low' => '',
            'sum_materials_high' => '',
            'sum_startworks_low' => '',
            'sum_startworks_high' => '',
            'sum_works_low' => '',
            'sum_works_high' => '',
            'sum_equips_low' => '',
            'sum_equips_high' => '',
            'sum_expences_low' => '',
            'sum_expences_high' => '',
            'sum_low_full' => '',
            'sum_high_full' => '',
            'sum_marj' => '',
            'percent_marj' => '',
        );
    }
}


