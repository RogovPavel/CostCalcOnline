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
    protected $alias;
    protected $field_id_with_tm;
    
    public $command; // Комманда для выполения модели
    public $proc_params;
    
    public function __construct($scenario = '') {
        parent::__construct($scenario);
        
        $this->command = Yii::app()->db->createCommand();
    }
    
    private function concat_sql() {
        
        $this->command->select = $this->select;
        $this->command->from = $this->from;
        $this->command->where = $this->where;
        $this->command->order = $this->order;
        if (!is_null($this->limit))
            $this->command->limit = $this->limit;
        
        $this->command->offset = $this->offset;
    }
    
    public function find($conditions = array()) {
        foreach ($conditions as $key => $value) {
            $this->command->andWhere($value['sql'], $value['params']);
        }
        
        // Добавляем фильтр по группе
        if (!Yii::app()->user->isGuest) {
            if (Yii::app()->user->group_id != 1)
                $this->command->andWhere($alias . '.group_id', $value['group_id']);
        }
        else {
            if (get_class($this) != 'Users')
                return array();
        }
        
        $res = $this->command->queryAll();
        return $res;
    }
    
    public function insert($params = array()) {
        $sp = new LSStoredProc();
    
        $sp->sp_proc_name = $this->sp_insert_name;
        $sp->proc_params = $this->proc_params[$this->sp_insert_name];
        
        if (count($params) > 0)
            $res = $sp->execute($params);
        else
            $res = $sp->execute($this);
        
        return array('tmp' => $res['tmp'], 'data' => $res['data'], 'sql' => $res['sql']);
        
    }
    
    public function update($params = array()) {
        $sp = new LSStoredProc();
    
        $sp->sp_proc_name = $this->sp_update_name;
        $sp->proc_params = $this->proc_params[$this->sp_update_name];
        
        if (count($params) > 0)
            $res = $sp->execute($params);
        else
            $res = $sp->execute($this);
        
        return array('tmp' => $res['tmp'], 'data' => $res['data']);
    }
    
    public function delete($params = array()) {
        $sp = new LSStoredProc();
    
        $sp->sp_proc_name = $this->sp_delete_name;
        $sp->proc_params = $this->proc_params[$this->sp_delete_name];
        
        if (count($params) > 0)
            $res = $sp->execute($params);
        else
            $res = $sp->execute($this);
        
        return array('tmp' => $res['tmp'], 'data' => $res['data']);
    }
    
    
    public function __get($property) {
        if (isset($this[$property]))
            return $this[$property];
    }
 
    public function __set($property, $value) {
        if (isset($this[$property]))
            $this[$property] = $value;
        
        $this->concat_sql();
    }
    
    public function get_by_id($id) {
        $this->command->andWhere($this->field_id_with_tm . ' = :p_id', array(':p_id' => $id));
        
        // Добавляем фильтр по группе
        if (!Yii::app()->user->isGuest) {
            if (Yii::app()->user->group_id != 1)
                $this->command->andWhere($alias . '.group_id', $value['group_id']);
        }
        else {
            if (get_class($this) != 'Users')
                return array();
        }
        
        $res = $this->command->queryRow();
        
        $this->setAttributes($res);
        return $res;
    }
    
    public function attributeFilters() {
        return array();
    }
    
    public function getattributeforfilters($fieldname) {
        $result = $fieldname;
        $attributefilters = $this->attributeFilters();
        
        if (isset($attributefilters[$fieldname])) 
            $result = $attributefilters[$fieldname];

        return $result; 
    }
}