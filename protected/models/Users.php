<?php

class Users extends LSFormModel {
    
    public $user_id;
    public $login;
    public $password;
    
    public $rolename;
    public $rolenameyii;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->command->select = ""
                . "u.user_id,"
                . " u.login,"
                . " u.password,"
                . " r.rolename,"
                . " r.rolenameyii,"
                . " u.group_id";
        $this->command->from = 'users u left join roles r on (u.role_id = r.role_id)';
        
//        $this->select = 'u.user_id, u.login, u.password, r.rolename, r.rolenameyii';
//        $this->from = 'users u left join roles r on (u.role_id = r.role_id)';
        
        
        $this->filed_id = 'user_id';
        $this->field_id_with_tm = 'u.user_id';
    }
    
    public function rules() {
        return array(
            array('user_id,
                    login,
                    password,
                    rolename,
                    rolenameyii,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'user_id' => '',
            'login' => '',
            'password' => '',
            'rolename' => '',
            'rolenameyii' => '',
            'group_id' => '',
        );
    }
}


