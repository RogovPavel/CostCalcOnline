<?php

class Banks extends LSFormModel {
    
    public $bank_id;
    public $bankname;
    public $city;
    public $account;
    public $bik;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_banks';
        $this->sp_update_name = 'update_banks';
        $this->sp_delete_name = 'delete_banks';
        
        $this->proc_params = array(
            'insert_banks' => array('bank_id', 'bankname', 'city', 'account', 'bik', 'user_create', 'group_id'),
            'update_banks' => array('bank_id', 'bankname', 'city', 'account', 'bik', 'user_change', 'group_id'),
            'delete_banks' => array('bank_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "b.bank_id,
                                    b.bankname,
                                    b.city,
                                    b.account,
                                    b.bik,
                                    b.date_create,
                                    b.user_create,
                                    b.date_change,
                                    b.user_change,
                                    b.group_id,
                                    b.deldate";
        $this->command->from = 'banks b left join users u on (b.user_create = u.user_id)';
        $this->command->where = 'b.deldate is null';
        $this->command->order = 'b.bankname';
        
                
        $this->filed_id = 'bank_id';
        $this->field_id_with_tm = 'b.bank_id';
        $this->alias = 'b.';
    }
    
    public function rules() {
        return array(
            array('bankname, city, account, bik', 'required'),
            array('bank_id,
                    bankname,
                    city,
                    account,
                    bik,
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
            'bank_id' => '',
            'bankname' => 'Наименование',
            'city' => 'Город',
            'account' => 'Р/Счет',
            'bik' => 'БИК',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


