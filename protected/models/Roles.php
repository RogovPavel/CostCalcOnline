<?php

class Roles extends LSFormModel {
    
    public $role_id;
    public $rolename;
    public $rolenameyii;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = '';
        $this->sp_update_name = '';
        $this->sp_delete_name = '';
        
        $this->proc_params = array(
            'insert_regions' => array(),
            'update_regions' => array(),
            'delete_regions' => array(),
        );
        
        $this->command->select = "r.role_id,
                                    r.rolename,
                                    r.rolenameyii,
                                    r.group_id";
        $this->command->from = 'roles r';
        $this->command->order = 'r.rolename';
        
                
        $this->filed_id = 'role_id';
        $this->field_id_with_tm = 'r.role_id';
        $this->alias = 'r.';
    }
    
    public function rules() {
        return array(
            array('role_id,
                    rolename,
                    rolenameyii,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'role_id' => '',
            'rolename' => '',
            'rolenameyii' => '',
            'group_id' => '',
        );
    }
}


