<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
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
                    else
                        $this->errorCode=self::ERROR_NONE;
                } 
                else
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
                
                return $this->errorCode;
                
                
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
	}
}