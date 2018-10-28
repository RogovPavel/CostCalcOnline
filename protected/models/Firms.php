<?php

class Firms extends LSFormModel {
    
    public $firm_id;
    public $firmname;
    public $inn;
    public $kpp;
    public $account;
    public $ogrn;
    public $okpo;
    public $bank_id;
    public $bankname;
    public $jur_address;
    public $fact_address;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_firms';
        $this->sp_update_name = 'update_firms';
        $this->sp_delete_name = 'delete_firms';
        
        $this->proc_params = array(
            'insert_firms' => array('firm_id', 'firmname', 'inn', 'kpp', 'account', 'ogrn', 'okpo', 'bank_id', 'jur_address', 'fact_address', 'user_create', 'group_id'),
            'update_firms' => array('firm_id', 'firmname', 'inn', 'kpp', 'account', 'ogrn', 'okpo', 'bank_id', 'jur_address', 'fact_address', 'user_change', 'group_id'),
            'delete_firms' => array('firm_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "f.firm_id,
                                    f.firmname,
                                    f.inn,
                                    f.kpp,
                                    f.account,
                                    f.ogrn,
                                    f.okpo,
                                    f.bank_id,
                                    b.bankname,
                                    f.jur_address,
                                    f.fact_address,
                                    f.date_create,
                                    f.user_create,
                                    f.date_change,
                                    f.user_change,
                                    f.group_id,
                                    f.deldate";
        $this->command->from = "firms f left join banks b on (f.bank_id = b.bank_id)
                                    left join users u on (f.user_create = u.user_id)";
        $this->command->where = 'f.deldate is null';
        $this->command->order = 'f.firmname';
        
                
        $this->filed_id = 'firm_id';
        $this->field_id_with_tm = 'f.firm_id';
        $this->alias = 'f.';
    }
    
    public function rules() {
        return array(
            array('firmname', 'required'),
            array('firm_id,
                    firmname,
                    inn,
                    kpp,
                    account,
                    ogrn,
                    okpo,
                    bank_id,
                    bankname,
                    jur_address,
                    fact_address,
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
            'firm_id' => '',
            'firmname' => 'Наименование',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'account' => 'Р/Счет',
            'ogrn' => 'ОГРН',
            'okpo' => 'ОКПО',
            'bank_id' => '',
            'bankname' => '',
            'jur_address' => '',
            'fact_address' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


