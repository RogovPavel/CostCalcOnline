<?php

class ObjectGroups extends LSFormModel {
    
    public $objectgr_id;
    public $region_id;
    public $street_id;
    public $house;
    public $corp;
    public $address;
    public $client_id;
    public $clientname;
    public $note; 
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_objectgroups';
        $this->sp_update_name = 'update_objectgroups';
        $this->sp_delete_name = 'delete_objectgroups';
        
        $this->proc_params = array(
            'insert_objectgroups' => array('objectgr_id', 'region_id', 'street_id', 'house', 'corp', 'client_id', 'note', 'user_create', 'group_id'),
            'update_objectgroups' => array('objectgr_id', 'region_id', 'street_id', 'house', 'corp', 'client_id', 'note', 'user_change', 'group_id'),
            'delete_objectgroups' => array('region_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  og.objectgr_id,
                                    og.region_id,
                                    og.street_id,
                                    og.house,
                                    og.corp,
                                    og.address,
                                    og.client_id,
                                    c.clientname,
                                    og.note";
        $this->command->from = 'objectgroups og left join clients c on (og.client_id = c.client_id)';
        $this->command->where = 'og.deldate is null';
        $this->command->order = 'og.address';
        
                
        $this->filed_id = 'objectgr_id';
        $this->field_id_with_tm = 'og.objectgr_id';
        $this->alias = 'og';
    }
    
    public function rules() {
        return array(
            array('region_id, street_id, house', 'required'),
            array('objectgr_id,
                    region_id,
                    street_id,
                    house,
                    corp,
                    address,
                    client_id,
                    clientname,
                    note', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'objectgr_id' => '',
            'region_id' => 'Регион',
            'street_id' => 'Улица',
            'house' => 'Дом',
            'corp' => 'Корпус',
            'address' => '',
            'client_id' => 'Клиент',
            'clientname' => '',
            'note' => '',
        );
    }
}


