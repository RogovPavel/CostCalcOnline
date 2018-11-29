<?php

class Settings extends LSFormModel {
    
    public $setting_id;
    public $user_id;
    public $theme;
    public $user_change;
    public $date_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_settings';
        $this->sp_update_name = 'update_settings';
        $this->sp_delete_name = 'delete_setings';
        
        $this->proc_params = array(
            'update_settings' => array('setting_id', 'user_id', 'theme', 'user_change', 'group_id'),
        );
        
        $this->command->select = "s.setting_id,
                                    s.user_id,
                                    s.theme,
                                    s.user_change,
                                    s.date_change,
                                    s.group_id,";
        $this->command->from = "settings s";
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
            'user_change' => '',
            'date_change' => '',
            'group_id' => '',
        );
    }
}

