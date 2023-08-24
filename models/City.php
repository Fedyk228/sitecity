<?php

namespace app\models;

use yii\db\ActiveRecord;



class City extends ActiveRecord
{

    static public function tableName()
    {
        return 'citys';
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'City name field required'],
            ['date_create', 'string']
        ];
    }

}



