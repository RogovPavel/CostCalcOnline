<?php

class LSPhpAuthManager extends CPhpAuthManager{
    public function init(){
        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if($this->authFile===null){
            $this->authFile = Yii::app()->basePath.'/config/auth.php';
        }
 
        parent::init();
 
        // Для гостей у нас и так роль по умолчанию guest.
        if(!Yii::app()->user->isGuest){
            // Связываем роль, заданную в БД с идентификатором пользователя,
            // возвращаемым UserIdentity.getId().
            $this->assign(Yii::app()->user->getRole(), Yii::app()->user->id);
        }
    }
}
