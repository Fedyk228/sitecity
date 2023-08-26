<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\City;
use app\models\Reviews;

use yii\web\Cookie;


class SiteController extends Controller
{
    public function actions()
    {
        return [
            // ...
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $cookies = Yii::$app->response->cookies;

        $cookies->add(new Cookie([
            'name' => 'city_save',
            'value' => 'default',
            'expire' => time() + 7200,
        ]));

        $citys = City::find()->orderBy(['name' => 'ASC'])->asArray()->all();

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
        $city_save = Yii::$app->request->cookies->getValue('city_save');

        if($city_save == 'default')
        {
            $cookies = Yii::$app->response->cookies;

            $cookies->add(new Cookie([
                'name' => 'city_save',
                'value' => Yii::$app->request->get('id'),
                'expire' => time() + 7200,
            ]));
        }


        $exist = UserController::checkLogin();

        $city = City::find()->where(['id' => Yii::$app->request->get('id')])->asArray()->one();



        if(!$city_save || $city == null)
            return $this->goBack('/web/site');

        $reviews = Reviews::find()->select('*')->innerJoin(User::tableName(), Reviews::tableName() . '.id_author = ' . User::tableName() . '.uid')->where(['id_city' => Yii::$app->request->get('id')])->asArray()->all();

        return $this->render('city', ['city' => $city, 'reviews' => $reviews]);
    }
}
