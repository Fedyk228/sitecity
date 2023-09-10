<?php

namespace app\models;

use yii\db\ActiveRecord;



class Reviews extends ActiveRecord
{

    static public function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Title field required'],
            ['text', 'string'],
            ['rating', 'integer'],
            ['id_city', 'integer'],
            ['img', 'string']
        ];
    }



}



