<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\City;
use app\models\Reviews;


class SiteController extends Controller
{
    public function actionIndex()
    {
        $citys = City::find()->asArray()->all();

        $geo = json_decode(file_get_contents('https://ipwho.is/' . $_SERVER['REMOTE_ADDR']), true);

        foreach ($citys as $city)
        {
            if($city['name'] == $geo['city'])
                $currentCity = $city;
        }


        return $this->render('index', ['login' => UserController::checkLogin(), 'citys' => $citys, 'currentCity' => $currentCity]);
    }

    public function actionCity()
    {
        $exist = UserController::checkLogin();

        if($exist == null)
            return $this->goBack('/web/user/login');

        $city = City::find()->where(['id' => Yii::$app->request->get('id')])->asArray()->one();

        if($city == null)
            return $this->goBack('/web/site');

        $reviews = Reviews::find()->select('*')->innerJoin(User::tableName(), Reviews::tableName() . '.id_author = ' . User::tableName() . '.uid')->where(['id_city' => Yii::$app->request->get('id')])->asArray()->all();

        return $this->render('city', ['city' => $city, 'reviews' => $reviews]);
    }
}
