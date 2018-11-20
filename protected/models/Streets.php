<?php

class Streets extends LSFormModel {
    
    public $street_id;
    public $streetname;
    public $streettype_id;
    public $streettype_name;
    public $region_id;
    public $region_name;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_streets';
        $this->sp_update_name = 'update_streets';
        $this->sp_delete_name = 'delete_streets';
        
        $this->proc_params = array(
            'insert_streets' => array('street_id', 'streetname', 'streettype_id', 'region_id', 'user_create', 'group_id'),
            'update_streets' => array('street_id', 'streetname', 'streettype_id', 'region_id', 'user_chnage', 'group_id'),
            'delete_streets' => array('street_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "s.street_id,
                                    concat(s.streetname, ' ', st.streettype_name) as streetname,
                                    s.streettype_id,
                                    st.streettype_name,
                                    s.region_id,
                                    r.region_name,
                                    s.date_create,
                                    s.user_create,
                                    s.date_change,
                                    s.user_change,
                                    s.group_id,
                                    s.deldate";
        $this->command->from = "streets s left join streettypes st on (s.streettype_id = st.streettype_id)
                                    left join regions r on (s.region_id = r.region_id)
                                    left join users u on (s.user_create = u.user_id)";
        $this->command->where = 's.deldate is null';
        $this->command->order = 'r.region_name, s.streetname';
        
                
        $this->filed_id = 'street_id';
        $this->field_id_with_tm = 's.street_id';
        $this->alias = 's.';
    }
    
    public function rules() {
        return array(
            array('streetname, streettype_id, region_id', 'required'),
            array('street_id,
                    streetname,
                    streettype_id,
                    streettype_name,
                    region_id,
                    region_name,
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
            'street_id' => '',
            'streetname' => 'Улица',
            'streettype_id' => 'Тип улицы',
            'streettype_name' => '',
            'region_id' => 'Регион',
            'region_name' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


