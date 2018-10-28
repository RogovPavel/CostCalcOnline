<?php

class Clients extends LSFormModel {
    
    public $client_id;
    public $clientname;
    public $inn;
    public $kpp;
    public $account;
    public $ogrn;
    public $okpo;
    public $bank_id;
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
        
        $this->sp_insert_name = 'insert_clients';
        $this->sp_update_name = 'update_clients';
        $this->sp_delete_name = 'delete_clients';
        
        $this->proc_params = array(
            'insert_regions' => array('client_id', 'clientname', 'inn', 'kpp', 'account', 'ogrn', 'okpo', 'bank_id', 'jur_address', 'fact_address', 'group_id', 'user_create'),
            'update_regions' => array('client_id', 'clientname', 'inn', 'kpp', 'account', 'ogrn', 'okpo', 'bank_id', 'jur_address', 'fact_address', 'group_id', 'user_change'),
            'delete_regions' => array('client_id', 'group_id', 'user_change'),
        );
        
        $this->command->select = "c.client_id,
                                    c.clientname,
                                    c.inn,
                                    c.kpp,
                                    c.account,
                                    c.ogrn,
                                    c.okpo,
                                    c.bank_id,
                                    b.bankname,
                                    c.jur_address,
                                    c.fact_address,
                                    c.date_create,
                                    c.user_create,
                                    c.date_change,
                                    c.user_change,
                                    c.group_id,
                                    c.deldate,";
        $this->command->from = "clients c left join banks b on (c.bank_id = b.bank_id)
                                    left join users u on (c.user_create = u.user_id)";
        $this->command->where = 'c.deldate is null';
        $this->command->order = 'c.clientname';
        
                
        $this->filed_id = 'client_id';
        $this->field_id_with_tm = 'c.client_id';
        $this->alias = 'c.';
    }
    
    public function rules() {
        return array(
            array('clientname', 'required'),
            array('client_id,
                    clientname,
                    inn,
                    kpp,
                    account,
                    ogrn,
                    okpo,
                    bank_id,
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
            'client_id' => '',
            'clientname' => 'Наименование',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'account' => 'Р/Счет',
            'ogrn' => 'ОГРН',
            'okpo' => 'ОКПО',
            'bank_id' => '',
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


