<?php

namespace app\models;

use yii\db\ActiveRecord;



class User extends ActiveRecord
{

    static private $Users = null;

    static public function tableName()
    {
        return 'authors';
    }

    static public function getUser($user_param, $type)
    {
        self::$Users = [
            ['fio' => 'Root', 'email' => 'root@mail.com', 'password' => 'qwerty123', 'role' => 'admin', 'auth_key' => 'qwertyhgfdsa']
        ];

        foreach (self::$Users as $user)
        {
            if($type == 'login')
            {
                if($user['email'] == $user_param['email'] && $user['password'] == $user_param['password'])
                    return $user;
            }
            else
            {
                if($user['auth_key'] == $user_param['auth_key'])
                    return $user;
            }
        }
    }

    public function rules()
    {
        return [
            [['email'], 'required', 'message' => 'Email field required'],
            [['password'], 'required', 'message' => 'Password field required'],
            ['email', 'email'],
            ['phone', 'string'],
            ['fio', 'string'],
            ['date_create', 'string'],
            ['auth_key', 'string'],
            ['token_activate', 'string'],
            ['is_active', 'boolean']
        ];
    }

}


