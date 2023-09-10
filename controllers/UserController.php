<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\User;
use app\models\RegisterUser;
use app\models\City;
use app\models\Reviews;
use yii\web\Cookie;


class UserController extends Controller
{
    public function actionIndex()
    {
        $model = new City();
        $modelReviews = new Reviews();
        $success = '';
        $err = '';
        $exist = self::checkLogin();

        if ($exist && isset($exist['role'])) {

            switch (CityController::add($exist))
            {
                case 'ok': $this->goBack($_SERVER['REQUEST_URI']); break;
                case 'err': $err = 'Add city error'; break;
            }

            switch (CityController::delete())
            {
                case 'ok': $this->goBack($_SERVER['REQUEST_URI']); break;
                case 'err': $err = 'Delete city error'; break;
            }


            return $this->render('root',
                                            [
                                                'model' => CityController::getModel(),
                                                'citys' => CityController::getAllCities(),
                                                'success' => $success,
                                                'err' => $err
                                            ]);
        } else if ($exist) {

            //ADD Review
            switch (ReviewsController::add($exist))
            {
                case 'ok': $this->goBack($_SERVER['REQUEST_URI']); break;
                case 'err': $err = 'Add review error'; break;
            }

            //DELETE Review
            switch (ReviewsController::delete($exist))
            {
                case 'ok': $this->goBack($_SERVER['REQUEST_URI']); break;
                case 'err': $err = 'Delete review error'; break;
            }

        }


        return $this->render('index', [
                                            'model' => ReviewsController::getModel(),
                                            'citys' => ArrayHelper::map(CityController::getAllCities(), 'cid', 'name'),
                                            'reviews' => ReviewsController::getUserReviews($exist),
                                            'success' => $success,
                                            'err' => $err
                                            ]);
    }

    public function actionCityEdit()
    {
        $exist = self::checkLogin();
        if (!$exist)
            $this->goBack('/web/user/login');


        $success = '';
        $err = '';

        switch (CityController::edit($exist))
        {
            case 'ok': $success = 'Save city success'; break;
            case 'err': $err = 'Save city error'; break;
        }


        return $this->render('city', [
                                            'model' => CityController::getCity(),
                                            'success' => $success,
                                            'err' => $err
                            ]);
    }

    public function actionReviewEdit()
    {
        $exist = self::checkLogin();
        if (!$exist)
            $this->goBack('/web/user/login');

        $success = '';
        $err = '';

        switch (ReviewsController::edit($exist))
        {
            case 'ok': $success = 'Save review success'; break;
            case 'err': $err = 'Save review error'; break;
        }


        return $this->render('review-edit', [
                                                    'model' => ReviewsController::getReview($exist),
                                                    'citys' => ArrayHelper::map(CityController::getAllCities(), 'cid', 'name'),
                                                    'success' => $success,
                                                    'err' => $err
                                                ]);
    }

    static public function checkLogin()
    {
        $cookies = Yii::$app->request->cookies;
        $auth_key = $cookies->getValue('auth_key');

        $root = User::getUser(['auth_key' => $auth_key], 'check_login');

        if ($root)
            return $root;

        return User::find()->where(['auth_key' => $auth_key])->asArray()->one();
    }

    public function actionLogout()
    {
        $cookies = Yii::$app->response->cookies;

        $cookies->add(new Cookie([
            'name' => 'auth_key',
            'value' => null,
            'expire' => time() - 1
        ]));

        $this->goBack('/web/user/login');
    }

    public function actionLogin()
    {
        $model = new User();
        $err = '';

        if ($model->load(Yii::$app->request->post())) {
            $email = Yii::$app->request->post('User')['email'];
            $password = Yii::$app->request->post('User')['password'];

            $root = User::getUser(['email' => $email, 'password' => $password], 'login');

            if ($root) {
                $this->successLogin($root['auth_key']);
            } else {
                $exist = User::find()->where(['email' => $email, 'password' => md5($password)])->one();

                if ($exist) {
                    if ($exist['is_active'] == 1) {
                        $auth_key = md5($email . Date('d.m.H.i.s'));

                        $exist->auth_key = $auth_key;

                        if ($exist->save()) {
                            $this->successLogin($auth_key);
                        }
                    } else {
                        $err = 'Your account is need activate!';
                    }

                } else {
                    $err = 'Incorrect login or password';
                }
            }

        }

        return $this->render('login', ['model' => $model, 'err' => $err]);
    }

    public function successLogin($auth_key)
    {
        $cookies = Yii::$app->response->cookies;

        $cookies->add(new Cookie([
            'name' => 'auth_key',
            'value' => $auth_key,
            'expire' => time() + 3600,
        ]));

        $this->goBack('/web/user');
    }

    public function actionActivate()
    {
        $exist = User::find()->where(['token_activate' => Yii::$app->request->get('t')])->one();


        if ($exist) {
            $exist->is_active = 1;
            $exist->token_activate = '';

//            echo '<pre>';
//            print_r($exist);
//            echo '</pre>';


            if ($exist->save())
                $success = true;
        }

        return $this->render('activate', ['success' => $success]);
    }


    public function actionRegister()
    {
        $model = new RegisterUser();
        $success = '';
        $err = '';

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->post('RegisterUser')['password'] != Yii::$app->request->post('r_password'))
                $err = 'Repeat password incorrect';
            else if (!RegisterUser::find()->where(['email' => Yii::$app->request->post('RegisterUser')['email']])->one()) {
                $model->date_create = Date('d.m.Y - H:i');
                $model->password = md5($model->password);
                $model->token_activate = md5(time() . $model->email);

                if ($model->save()) {
                    $model->password = '';
                    $success = 'Register success. Please check your email and activate account';
                    $this->sendMail($model->email, $model->token_activate);
                }

            } else
                $err = 'This email is already';
        }

        return $this->render('register', ['model' => $model, 'success' => $success, 'err' => $err]);
    }

    private function sendMail($email, $token)
    {
        $to = $email;
        $from = 'noreply-activate@cs43884.tw1.ru';

        $subject = "Activate your account";
        $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
        $headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/html; charset=utf-8\r\n";


        $message = '
            <h1>Activate account please open link</h1>
            <a href="http://cs43884.tw1.ru/web/user/activate?t=' . $token . '">Press activate link</a>
        ';

        mail($to, $subject, $message, $headers);
    }
}
