<?php

class TemplateTypes extends LSFormModel {
    
    public $type_id;
    public $typename;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = '';
        $this->sp_update_name = '';
        $this->sp_delete_name = '';
        
        $this->proc_params = array(
        );
        
        $this->command->select = "  t.type_id,
                                    t.typename,
                                    t.group_id,
                                    t.deldate";
        $this->command->from = "templatetypes t";
        $this->command->where = 't.deldate is null';
        $this->command->order = 't.typename';
        
                
        $this->filed_id = 'type_id';
        $this->field_id_with_tm = 't.type_id';
        $this->alias = 't.';
    }
    
    public function rules() {
        return array(
            array('typename', 'required'),
            array('type_id,
                    typename,
                    group_id,
                    deldate', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'type_id' => '',
            'typename' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


