<?php

class Templates extends LSFormModel {
    
    public $template_id;
    public $templatename;
    public $type_id;
    public $typename;
    public $active;
    public $template;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->fieldsnodef = array('template');
        
        $this->sp_insert_name = 'insert_templates';
        $this->sp_update_name = 'update_templates';
        $this->sp_delete_name = 'delete_templates';
        
        $this->proc_params = array(
            'insert_templates' => array('template_id', 'templatename', 'type_id', 'active', 'template', 'user_create', 'group_id'),
            'update_templates' => array('template_id', 'templatename', 'type_id', 'active', 'template', 'user_change', 'group_id'),
            'delete_templates' => array('template_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  t.template_id,
                                    t.templatename,
                                    t.type_id,
                                    tp.typename,
                                    t.active,
                                    t.template,
                                    t.date_create,
                                    t.user_create,
                                    t.date_change,
                                    t.user_change,
                                    t.group_id,
                                    t.deldate";
        $this->command->from = "templates t left join templatetypes tp on (t.type_id = tp.type_id)";
        $this->command->where = 't.deldate is null';
        $this->command->order = 't.template_id';
        
                
        $this->filed_id = 'template_id';
        $this->field_id_with_tm = 't.template_id';
        $this->alias = 't.';
    }
    
    public function rules() {
        return array(
            array('templatename, type_id, template', 'required'),
            array('template_id,
                    templatename,
                    type_id,
                    typename,
                    active,
                    template,
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
            'template_id' => '',
            'templatename' => '',
            'type_id' => '',
            'typename' => '',
            'active' => '',
            'template' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


