<?php

class LSFormModel extends CFormModel
{
    public $sp_insert_name; // Наименование хранимой процедуры вставки
    public $sp_update_name; // Наименование хранимой процедуры редактирования
    public $sp_delete_name; // Наименование хранимой процедуры удаления
    
    protected $select; // Блок Select
    protected $from; // Блок From
    protected $where; // Блок Where
    protected $order; // Блок Order by
    protected $limit; // Блок Limit
    protected $offset; // Блок Offset
    
    
    protected $sql;
    
    protected $filed_id;
    protected $field_id_with_tm;
    
    public $command; // Комманда для выполения модели
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->command = Yii::app()->db->createCommand();
    }
    
    private function concat_sql() {
        $this->command->select = $this->select;
        $this->command->from = $this->from;
        $this->command->where = $this->where;
        $this->command->order = $this->order;
        $this->command->limit = $this->limit;
        $this->command->offset = $this->offset;
    }
    
    public function find($conditions = array()) {
        foreach ($conditions as $key => $value) {
            $this->command->andWhere($value['sql'], $value['params']);
        }

        $res = $this->command->queryAll();
        return $res;
    }
    
    public function insert() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
    
    
    public function __get($property) {
        switch ($property) {
            case 'select':
                return $this->select;
                break;
            case 'from':
                return $this->from;
                break;
            case 'where':
                return $this->where;
                break;
            case 'order':
                return $this->order;
                break;
            case 'limit':
                return $this->limit;
                break;
            case 'sql':
                return $this->sql;
                break;
            case 'offset':
                return $this->offset;
                break;
        }
    }
 
    public function __set($property, $value) {
        switch ($property) {
            case 'select':
                $this->select = $value;
                $this->concat_sql();
                break;
            case 'from':
                $this->from = $value;
                $this->concat_sql();
                break;
            case 'where':
                $this->where = $value;
                $this->concat_sql();
                break;
            case 'order':
                $this->order = $value;
                $this->concat_sql();
                break;
            case 'limit':
                $this->limit = $value;
                $this->concat_sql();
                break;
            case 'offset':
                $this->offset = $value;
                $this->concat_sql();
                break;
        }
    }
}