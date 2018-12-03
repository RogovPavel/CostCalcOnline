<?php

class ObjectGroupContacts extends LSFormModel {
    
    public $contact_id;
    public $objectgr_id;
    public $firstname;
    public $surname;
    public $lastname;
    public $fullname;
    public $position_id;
    public $positionname;
    public $phonenumber;
    public $email;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_objectgroupcontacts';
        $this->sp_update_name = 'update_objectgroupcontacts';
        $this->sp_delete_name = 'delete_objectgroupcontacts';
        
        $this->proc_params = array(
            'insert_objectgroupcontacts' => array('contact_id', 'objectgr_id', 'firstname', 'surname', 'lastname', 'position_id', 'phonenumber', 'email', 'user_create', 'group_id'),
            'update_objectgroupcontacts' => array('contact_id', 'objectgr_id', 'firstname', 'surname', 'lastname', 'position_id', 'phonenumber', 'email', 'user_create', 'group_id'),
            'delete_objectgroupcontacts' => array('contact_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  ogc.contact_id,
                                    ogc.objectgr_id,
                                    ogc.firstname,
                                    ogc.surname,
                                    ogc.lastname,
                                    ogc.fullname,
                                    ogc.position_id,
                                    cp.positionname,
                                    ogc.phonenumber,
                                    ogc.email,
                                    ogc.date_create,
                                    ogc.user_create,
                                    ogc.date_change,
                                    ogc.user_change,
                                    ogc.group_id,
                                    ogc.deldate";
        $this->command->from = 'objectgroupcontacts ogc left join clientpositions cp on (ogc.position_id = cp.position_id)';
        $this->command->where = 'ogc.deldate is null';
        $this->command->order = 'ogc.contact_id';
        
                
        $this->filed_id = 'contact_id';
        $this->field_id_with_tm = 'ogc.contact_id';
        $this->alias = 'ogc';
    }
    
    public function rules() {
        return array(
            array('objectgr_id, firstname, surname', 'required'),
            array('contact_id,
                    objectgr_id,
                    firstname,
                    surname,
                    lastname,
                    fullname,
                    position_id,
                    positionname,
                    phonenumber,
                    email,
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
            'contact_id' => '',
            'objectgr_id' => '',
            'firstname' => 'Имя',
            'surname' => 'Фамилия',
            'lastname' => 'Отчество',
            'fullname' => '',
            'position_id' => '',
            'positionname' => '',
            'phonenumber' => '',
            'email' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


