<?php

class StreetTypes extends LSFormModel {
    
    public $streettype_id;
    public $streettype_name;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_streettypes';
        $this->sp_update_name = 'update_streettypes';
        $this->sp_delete_name = 'delete_streettypes';
        
        $this->proc_params = array(
            'insert_regions' => array('streettype_id', 'streettype_name', 'user_create', 'group_id'),
            'update_regions' => array('streettype_id', 'streettype_name', 'user_change', 'group_id'),
            'delete_regions' => array('streettype_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "st.streettype_id,
                                    st.streettype_name,
                                    st.date_create,
                                    st.user_create,
                                    st.date_change,
                                    st.user_change,
                                    st.group_id,
                                    st.deldate";
        $this->command->from = 'streettypes st left join users u on (st.user_create = u.user_id)';
        $this->command->where = 'st.deldate is null';
        $this->command->order = 'st.streettype_name';
        
                
        $this->filed_id = 'streettype_id';
        $this->field_id_with_tm = 'st.streettype_id';
        $this->alias = 'st.';
    }
    
    public function rules() {
        return array(
            array('streettype_name', 'required'),
            array('streettype_id,
                    streettype_name,
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
            'streettype_id' => '',
            'streettype_name' => 'Тип улицы',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


