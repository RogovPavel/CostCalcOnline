<?php

class WebUser extends CWebUser {
    
    private $_model = null;
    
    public function getRole() {
        if($user = $this->getModel()){
            return $user->rolenameyii;
        }
    }
    
    public function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $model = new Users();
            $model->get_by_id($this->id);
            $this->_model = $model;
        }
        return $this->_model;
    }
}
