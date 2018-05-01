<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $user = User::model()->find(array('condition' =>
            'active=1 and (email="' . $this->username . '")',
        ));
        if ($user === null) {

            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if ($user->check($this->password)) {

            $this->_id = $user->id;
            $this->setState('username', $user->username);
            $this->setState('useremail', $user->email);
            $this->setState('usertype', $user->user_type);
            $this->setState('userimage', $user->image);

            if ($user->user_type != Yii::app()->params['Admin']) {
                //get user permissions and add them in array
                $user_permission=UserPermission::model()->find(array('condition' => 'user_id=' . $user->id));
                $permissions=array();
                if($user_permission){
                    foreach ($user_permission as $k=>$up) {
                        $permissions[$k]=$up;
                    }
                }
                Yii::app()->user->setState('userpermissions', $permissions);
                Yii::app()->user->setState('company', $user->company_id); //to filter with it only
            }

            $this->errorCode = self::ERROR_NONE;
        } else {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }


        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
