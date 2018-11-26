<?php

class DemandComments extends LSFormModel {
    
    public $comment_id;
    public $demand_id;
    public $date;
    public $user_id;
    public $shortname;
    public $text;
    public $user_create;
    public $date_create;
    public $user_change;
    public $date_change;
    public $group_id;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->sp_insert_name = 'insert_demandcomments';
        $this->sp_update_name = '';
        $this->sp_delete_name = 'delete_demandcomments';
        
        $this->proc_params = array(
            'insert_demandcomments' => array('comment_id', 'demand_id', 'text', 'user_create', 'group_id'),
            'delete_demandcomments' => array('comment_id', 'user_change', 'group_id'),
        );
        
        $this->command->select = "  dc.comment_id,
                                    dc.demand_id,
                                    dc.date,
                                    dc.user_id,
                                    u.shortname,
                                    dc.text,
                                    dc.user_create,
                                    dc.date_create,
                                    dc.user_change,
                                    dc.date_change,
                                    dc.group_id";
        $this->command->from = 'demandcomments dc left join users u on (dc.user_id = u.user_id)';
        $this->command->where = 'dc.deldate is null';
        $this->command->order = 'dc.comment_id desc';
                
        $this->filed_id = 'comment_id';
        $this->field_id_with_tm = 'dc.comment_id';
        $this->alias = 'dc';
    }
    
    public function rules() {
        return array(
            array('demand_id, text', 'required'),
            array('comment_id,
                    demand_id,
                    date,
                    user_id,
                    shortname,
                    text,
                    user_create,
                    date_create,
                    user_change,
                    date_change,
                    group_id', 'safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'comment_id' => '',
            'demand_id' => '',
            'date' => '',
            'user_id' => '',
            'shortname' => '',
            'text' => 'Текст',
            'user_create' => '',
            'date_create' => '',
            'user_change' => '',
            'date_change' => '',
            'group_id' => '',
        );
    }
    
    public function attributeFilters() {
        return array(
            
        );
    }
}


