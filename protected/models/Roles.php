<?php

class Users extends LSFormModel {
    
    public $role_id;
    public $rolename;
    public $password;
    
    public function rules()
    {
        return array(
            array('user_id,
                    login,
                    password', 'safe'),
        );
    }
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->command->select = 'r.role_id, r.rolename, r.rolenameyii';
        $this->command->from = 'roles r';
    }
    
    public function attributeLabels() {
        return array(
            'user_id' => '',
            'login' => '',
            'password' => '',
        );
    }
}


