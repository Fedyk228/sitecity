<?php

namespace app\models;

use yii\db\ActiveRecord;


class RegisterUser extends ActiveRecord
{

    static public function tableName()
    {
        return 'authors';
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
            ['is_active', 'boolean'],
            ['verifyCode', 'captcha']
        ];
    }

}


