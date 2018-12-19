<?php

class CostCalcPayments extends LSFormModel {
    
    public $payment_id;
    public $calc_id;
    public $user_id;
    public $sumpay;
    public $user_create;
    public $date_create;
    public $user_change;
    public $date_change;
    public $deldate;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_costcalcpayments';
        $this->sp_update_name = 'update_costcalcpayments';
        $this->sp_delete_name = 'delete_costcalcpayments';
        
        $this->proc_params = array(
            'insert_costcalcpayments' => array('payment_id', 'calc_id', 'user_id', 'sumpay', 'user_create', 'group_id'),
            'update_costcalcpayments' => array('payment_id', 'calc_id', 'user_id', 'sumpay', 'user_change', 'group_id'),
            'delete_costcalcpayments' => array('payment_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "p.payment_id,
                                    p.calc_id,
                                    p.user_id,
                                    u.shortname,
                                    p.sumpay,
                                    p.user_create,
                                    p.date_create,
                                    p.user_change,
                                    p.date_change,
                                    p.deldate,
                                    p.group_id,";
        $this->command->from = 'costcalcpayments p left join users u on (p.user_id = u.user_id)';
        $this->command->where = 'p.deldate is null';
        $this->command->order = 'p.payment_id';
        
                
        $this->filed_id = 'payment_id';
        $this->field_id_with_tm = 'p.payment_id';
        $this->alias = 'p.';
    }
    
    public function rules() {
        return array(
            array('calc_id, user_id, sumpay', 'required'),
            array('payment_id,
                    calc_id,
                    user_id,
                    sumpay,
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
            'payment_id' => '',
            'calc_id' => '',
            'user_id' => '',
            'sumpay' => '',
            'user_create' => '',
            'date_create' => '',
            'user_change' => '',
            'date_change' => '',
            'deldate' => '',
            'group_id' => '',
        );
    }
}


