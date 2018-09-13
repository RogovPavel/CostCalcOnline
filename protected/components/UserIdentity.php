<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    private $_id;
    
    public function authenticate() {
        $users = new Users();
        $res = $users->find(array(
            array(
                'sql'=>'u.login=:p1',
                'params' => array(':p1'=>$this->username)
            )
        ));

        if (count($res) > 0) {
            // Пользователь с таким логином найден
            if ($res[0]['password'] !== $this->password)
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else {
                $this->errorCode=self::ERROR_NONE;
                $this->_id = $res[0]['user_id'];
                $this->setState('login', $res[0]['login']);
                $this->setState('user_id', $res[0]['user_id']);
                $this->setState('group_id', $res[0]['group_id']);
            }
        } 
        else
            $this->errorCode=self::ERROR_USERNAME_INVALID;

        return $this->errorCode;
    }
    
    public function getId(){
        return $this->_id;
    }
}