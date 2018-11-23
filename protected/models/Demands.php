<?php

class Demands extends LSFormModel {
    
    public $demand_id;
    public $date_reg;
    public $object_id;
    public $objectgr_id;
    public $address;
    public $client_id;
    public $clientname;
    public $status_id;
    public $status_name;
    public $demandtype_id;
    public $demandtype_name;
    public $prior_id;
    public $demandprior_name;
    public $deadline;
    public $demand_text;
    public $contact;
    public $date_exec;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_demands';
        $this->sp_update_name = 'update_demands';
        $this->sp_delete_name = 'delete_demands';
        
        $this->proc_params = array(
            'insert_demands' => array('demand_id', 'client_id', 'objectgr_id', 'object_id', 'demandtype_id', 'date_reg', 'prior_id', 'deadline', 'demand_text', 'contact', 'user_create', 'group_id'),
            'update_demands' => array('objectgr_id', 'region_id', 'street_id', 'house', 'corp', 'client_id', 'note', 'user_change', 'group_id'),
            'delete_demands' => array('region_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  d.demand_id,
                                    d.date_reg,
                                    d.object_id,
                                    d.objectgr_id,
                                    IF (o.address is Null, og.address, o.address) as address,
                                    d.client_id,
                                    c.clientname,
                                    d.status_id,
                                    ds.status_name,
                                    d.demandtype_id,
                                    dt.demandtype_name,
                                    d.prior_id,
                                    dp.demandprior_name,
                                    d.deadline,
                                    d.demand_text,
                                    d.contact,
                                    d.date_exec,
                                    d.date_create,
                                    d.user_create,
                                    d.date_change,
                                    d.user_change,
                                    d.group_id";
        $this->command->from = 'demands d LEFT JOIN objects o on (d.object_id = o.object_id)
                                    LEFT JOIN objectgroups og on (d.objectgr_id = og.objectgr_id)
                                    LEFT JOIN clients c on (d.client_id = c.client_id)
                                    LEFT JOIN demandstatus ds on (d.status_id = ds.status_id)
                                    LEFT JOIN demandtypes dt on (d.demandtype_id = dt.demandtype_id)
                                    LEFT JOIN demandpriors dp on (d.prior_id = dp.demandprior_id)
                                    LEFT join users u on (d.user_create = u.shortname)';
        $this->command->where = 'd.deldate is null';
        $this->command->order = 'd.date_reg desc';
                
        $this->filed_id = 'demand_id';
        $this->field_id_with_tm = 'd.demand_id';
        $this->alias = 'd';
    }
    
    public function rules() {
        return array(
            array('demandtype_id, prior_id, demand_text', 'required'),
            array('demand_id,
                    date_reg,
                    object_id,
                    objectgr_id,
                    address,
                    client_id,
                    clientname,
                    status_id,
                    status_name,
                    demandtype_id,
                    demandtype_name,
                    prior_id,
                    demandprior_name,
                    deadline,
                    demand_text,
                    contact,
                    date_exec,
                    date_create,
                    user_create,
                    date_change,
                    user_change,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'demand_id' => '',
            'date_reg' => '',
            'object_id' => '',
            'objectgr_id' => '',
            'address' => '',
            'client_id' => '',
            'clientname' => '',
            'status_id' => '',
            'status_name' => '',
            'demandtype_id' => 'Тип заявки',
            'demandtype_name' => '',
            'prior_id' => 'Приоритет',
            'demandprior_name' => '',
            'deadline' => '',
            'demand_text' => 'Тест заявки',
            'contact' => '',
            'date_exec' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
        );
    }
    
    public function attributeFilters() {
        return array(
            'address' => 'IF (o.address is null, og.address, o.address)',
        );
    }
}


