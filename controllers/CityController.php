<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\City;


class CityController extends Controller
{
    static  function getModel()
    {
        return new City();
    }

    static function getAllCities()
    {
        return City::find()->asArray()->all();
    }

    static function getCity()
    {
        return City::find()->where(['cid' => Yii::$app->request->get('id')])->one();
    }

    static function add()
    {
        $model = self::getModel();

        if ($model->load(Yii::$app->request->post())) {
            $model->date_create = Date('d.m.Y - H:i');

            if($model->save())
                return 'ok';
            else
                return 'err';
        }

    }

    static function edit()
    {
        $model = self::getCity();

        if ($model->load(Yii::$app->request->post())) {

            if($model->save())
                return 'ok';
            else
                return 'err';
        }
    }

    static function delete()
    {
            if (Yii::$app->request->post('id')) {
                $model = City::find()->where(['cid' => Yii::$app->request->post('id')])->one();

                if($model->delete())
                    return 'ok';
                else
                    return 'err';

            }
    }
}
