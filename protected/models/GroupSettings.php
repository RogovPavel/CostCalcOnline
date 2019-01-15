<?php

class GroupSettings extends LSFormModel {
    
    public $setting_id;
    public $user_id;
    public $theme;
    public $logo;
    public $host;
    public $port;
    public $username;
    public $password;
    public $fromaddress;
    public $templatefordemands;
    public $user_change;
    public $date_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_groupsettings';
        $this->sp_update_name = 'update_groupsettings';
        $this->sp_delete_name = 'delete_groupsetings';
        
        $this->proc_params = array(
            'update_groupsettings' => array('setting_id', 'user_id', 'theme', 'logo', 'host', 'port', 'username', 'password', 'fromaddress', 'templatefordemands', 'user_change', 'group_id'),
        );
        
        $this->command->select = "s.setting_id,
                                    s.user_id,
                                    s.logo,
                                    s.theme,
                                    s.host,
                                    s.port,
                                    s.username,
                                    s.password,
                                    s.fromaddress,
                                    s.templatefordemands,
                                    s.user_change,
                                    s.date_change,
                                    s.group_id,";
        $this->command->from = "groupsettings s";
        $this->command->order = 's.setting_id';
        
                
        $this->filed_id = 'setting_id';
        $this->field_id_with_tm = 's.setting_id';
        $this->alias = 's.';
    }
    
    public function rules() {
        return array(
            array('user_id, theme', 'required'),
            array('setting_id,
                    user_id,
                    theme,
                    logo,
                    host,
                    port,
                    username,
                    password,
                    fromaddress,
                    templatefordemands,
                    user_change,
                    date_change,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'setting_id' => '',
            'user_id' => '',
            'theme' => '',
            'logo' => '',
            'host' => '',
            'port' => '',
            'username' => '',
            'password' => '',
            'fromaddress' => '',
            'templatefordemands' => '',
            'user_change' => '',
            'date_change' => '',
            'group_id' => '',
        );
    }
}


