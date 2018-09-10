<?php

class Users extends LSFormModel {
    
    public $user_id;
    public $login;
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
        
        $this->command->select = 'u.user_id, u.login, u.password';
        $this->command->from = 'users u';
    }
    
    public function attributeLabels() {
        return array(
            'user_id' => '',
            'login' => '',
            'password' => '',
        );
    }
}


