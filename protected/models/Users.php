<?php

class Users extends LSFormModel {
    
    public $user_id;
    public $login;
    public $password;
    public $firstname;
    public $surname;
    public $lastname;
    public $fullname;
    public $shortname;
    public $birthday;
    public $sex;
    public $work_phonenumber;
    public $home_phonenumber;
    public $work_email;
    public $role_id;
    public $rolename;
    public $rolenameyii;
    public $banned;
    public $date_create;
    public $user_create;
    public $date_change;
    public $user_change;
    public $group_id;
    public $deldate;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_users';
        $this->sp_update_name = 'update_users';
        $this->sp_delete_name = 'delete_users';
        
        $this->proc_params = array(
            'insert_users' => array('user_id', 'login', 'password', 'firstname', 'surname', 'lastname', 'birthday', 'sex', 'work_phonenumber', 'home_phonenumber', 'work_email', 'role_id', 'user_create', 'group_id'),
            'update_users' => array('user_id', 'login', 'password', 'firstname', 'surname', 'lastname', 'birthday', 'sex', 'work_phonenumber', 'home_phonenumber', 'work_email', 'role_id', 'user_change', 'group_id'),
            'delete_users' => array('user_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = 'u.user_id,
                                    u.login,
                                    u.password,
                                    u.firstname,
                                    u.surname,
                                    u.lastname,
                                    u.fullname,
                                    u.shortname,
                                    u.birthday,
                                    u.sex,
                                    u.work_phonenumber,
                                    u.home_phonenumber,
                                    u.work_email,
                                    u.role_id,
                                    r.rolename,
                                    r.rolenameyii,
                                    u.banned,
                                    u.date_create,
                                    u.user_create,
                                    u.date_change,
                                    u.user_change,
                                    u.group_id,
                                    u.deldate';
        $this->command->from = 'users u left join roles r on (u.role_id = r.role_id)';
        $this->command->where = 'u.deldate is null';

        
        
        $this->filed_id = 'user_id';
        $this->field_id_with_tm = 'u.user_id';
        $this->alias = 'u';
    }
    
    public function rules() {
        return array(
            array('user_id,
                    login,
                    password,
                    firstname,
                    surname,
                    lastname,
                    fullname,
                    shortname,
                    birthday,
                    sex,
                    work_phonenumber,
                    home_phonenumber,
                    work_email,
                    role_id,
                    rolename,
                    rolenameyii,
                    banned,
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
            'user_id' => '',
            'login' => '',
            'password' => '',
            'firstname' => '',
            'surname' => '',
            'lastname' => '',
            'fullname' => '',
            'shortname' => '',
            'birthday' => '',
            'sex' => '',
            'work_phonenumber' => '',
            'home_phonenumber' => '',
            'work_email' => '',
            'role_id' => '',
            'rolename' => '',
            'rolenameyii' => '',
            'banned' => '',
            'date_create' => '',
            'user_create' => '',
            'date_change' => '',
            'user_change' => '',
            'group_id' => '',
            'deldate' => '',
        );
    }
}


