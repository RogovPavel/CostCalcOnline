<?php

class CostCalculations extends LSFormModel {
    
    public $calc_id;
    public $type;
    public $name;
    public $typename;
    public $date;
    public $status_id;
    public $client_id;
    public $clientname;
    public $objectgr_id;
    public $address;
    public $demand_id;
    public $firm_id;
    public $firmname;
    public $manager_id;
    public $shortname;
    public $contact;
    public $specnote;
    public $note;
    public $koef;
    public $discount;
    public $date_ready;
    public $user_ready;
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
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_costcalculations';
        $this->sp_update_name = 'update_costcalculations';
        $this->sp_delete_name = 'delete_costcalculations';
        
        $this->proc_params = array(
            'insert_costcalculations' => array('calc_id', 'date', 'type', 'name', 'client_id', 'objectgr_id', 'demand_id', 'firm_id', 'manager_id', 'contact', 'specnote', 'note', 'user_create', 'group_id'),
            'update_costcalculations' => array('calc_id', 'date', 'type', 'name', 'client_id', 'objectgr_id', 'demand_id', 'firm_id', 'manager_id', 'contact', 'specnote', 'note', 'user_create', 'group_id'),
            'delete_costcalculations' => array('calc_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  c.calc_id,
                                    c.type,
                                    c.name,
                                    t.typename,
                                    c.date,
                                    c.status_id,
                                    c.client_id,
                                    cl.clientname,
                                    c.objectgr_id,
                                    og.address,
                                    c.demand_id,
                                    c.firm_id,
                                    f.firmname,
                                    c.manager_id,
                                    u.shortname,
                                    c.contact,
                                    c.specnote,
                                    c.note,
                                    c.koef,
                                    c.discount,
                                    c.date_ready,
                                    c.user_ready,
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
                                    c.percent_marj,
                                    c.date_create,
                                    c.user_create,
                                    c.date_change,
                                    c.user_change,
                                    c.group_id";
        $this->command->from = 'costcalculations c left join clients cl on (c.client_id = cl.client_id)
                                    left join objectgroups og on (c.objectgr_id = og.objectgr_id)
                                    left join firms f on (c.firm_id = f.firm_id)
                                    left join users u on (c.manager_id = u.user_id)
                                    left join costcalctypes t on (c.type = t.type_id)';
        $this->command->where = 'c.deldate is null';
        $this->command->order = 'c.calc_id desc';
                
        $this->filed_id = 'calc_id';
        $this->field_id_with_tm = 'c.calc_id';
        $this->alias = 'c';
    }
    
    public function rules() {
        return array(
            array('objectgr_id', 'required'),
            array('calc_id,
                    type,
                    name,
                    typename,
                    date,
                    status_id,
                    client_id,
                    clientname,
                    objectgr_id,
                    address,
                    demand_id,
                    firm_id,
                    firmname,
                    manager_id,
                    shortname,
                    contact,
                    specnote,
                    note,
                    koef,
                    discount,
                    date_ready,
                    user_ready,
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
                    percent_marj,
                    date_create,
                    user_create,
                    date_change,
                    user_change,
                    group_id,', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'calc_id' => '',
            'type' => '',
            'name' => '',
            'typename' => '',
            'date' => '',
            'status_id' => '',
            'client_id' => '',
            'clientname' => '',
            'objectgr_id' => '',
            'address' => '',
            'demand_id' => '',
            'firm_id' => '',
            'firmname' => '',
            'manager_id' => '',
            'shortname' => '',
            'contact' => '',
            'specnote' => '',
            'note' => '',
            'koef' => '',
            'discount' => '',
            'date_ready' => '',
            'user_ready' => '',
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
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
        );
    }
    
    public function attributeFilters() {
        return array(
            '' => '',
        );
    }
}


