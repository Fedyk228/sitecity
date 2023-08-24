<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
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

        if($exist && isset($exist['role']))
        {
            if($model->load(Yii::$app->request->post()))
            {
                    $model->date_create = Date('d.m.Y - H:i');

                    if($model->save())
                        $this->goBack($_SERVER['REQUEST_URI']);
                    else
                        $err = 'Add city error';
            }

            if(Yii::$app->request->post('id'))
            {
                $city = City::find()->where(['id' => Yii::$app->request->post('id')])->one();

                if($city->delete())
                    $this->goBack($_SERVER['REQUEST_URI']);

            }

            return $this->render('root', ['model' => $model, 'success' => $success, 'err' => $err, 'citys' => $this->getCitys()]);
        }
        else if($exist)
        {
            $reviews = Reviews::find()->where(['id_author' => $exist['uid']])->orderBy(['id' => SORT_DESC])->asArray()->all();

            if($modelReviews->load(Yii::$app->request->post()))
            {
                $modelReviews->date_create = Date('d.m.Y - H:i');
                $modelReviews->id_author = $exist['uid'];

                $filename = '';

                if(!empty($_FILES['Reviews']['name']['img'])) {
                    $ext = strtolower(array_pop(explode('.', $_FILES['Reviews']['name']['img'])));
                    $filename = 'file' . time() . '.' . $ext;

                    move_uploaded_file($_FILES['Reviews']['tmp_name']['img'], '../upload/' . $filename);
                }

                $modelReviews->img = $filename;

                if($modelReviews->save())
                    $this->goBack($_SERVER['REQUEST_URI']);
                else
                    $err = 'Add review error';
            }

            if(Yii::$app->request->post('id'))
            {
                $review = Reviews::find()->where(['id' => Yii::$app->request->post('id'), 'id_author' => $exist['uid']])->one();


                if($review->delete())
                    $this->goBack($_SERVER['REQUEST_URI']);
            }

        }



        return $this->render('index', ['model' => $modelReviews, 'citys' => $this->getCitysDropdown($this->getCitys()), 'reviews' => $reviews, 'success' => $success, 'err' => $err]);
    }

    public function getCitys()
    {
        return City::find()->asArray()->all();
    }

    public function getCitysDropdown($citys)
    {
        $citysDropdown = [];

        foreach($citys as $city)
        {
            $citysDropdown[$city['id']] = $city['name'];
        }

        return $citysDropdown;
    }


    public function actionCityEdit()
    {
        $exist = self::checkLogin();
        if(!$exist)
            $this->goBack('/web/user/login');

        $model = City::find()->where(['id' => Yii::$app->request->get('id')])->one();
        $success = '';
        $err = '';

        if($model->load(Yii::$app->request->post()))
        {
            if($model->save())
                $success = 'Save city success';
            else
                $err = 'Save city error';
        }

        return $this->render('city', ['model' => $model, 'citys' => $this->getCitysDropdown($this->getCitys()), 'success' => $success, 'err' => $err]);
    }

    public function actionReviewEdit()
    {
        $exist = self::checkLogin();
        if(!$exist)
            $this->goBack('/web/user/login');

        $model = Reviews::find()->where(['id' => Yii::$app->request->get('id'), 'id_author' => $exist['uid']])->one();

        $filename = $model->img;
        $success = '';
        $err = '';

        if($model->load(Yii::$app->request->post()))
        {
            if(!empty($_FILES['Reviews']['name']['img'])) {

                if($filename)
                    unlink('../upload/' . $filename);

                $ext = strtolower(array_pop(explode('.', $_FILES['Reviews']['name']['img'])));
                $filename = 'file' . time() . '.' . $ext;

                move_uploaded_file($_FILES['Reviews']['tmp_name']['img'], '../upload/' . $filename);
            }

            $model->img = $filename;

            if($model->save())
                $success = 'Save review success';
            else
                $err = 'Save review error';
        }


        return $this->render('review-edit', ['model' => $model, 'citys' => $this->getCitysDropdown($this->getCitys()), 'success' => $success, 'err' => $err]);
    }

    static public function checkLogin()
    {
        $cookies = Yii::$app->request->cookies;
        $auth_key = $cookies->getValue('auth_key');

        $root = User::getUser(['auth_key' => $auth_key], 'check_login');

        if($root)
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

        if($model->load(Yii::$app->request->post()))
        {
            $email = Yii::$app->request->post('User')['email'];
            $password = Yii::$app->request->post('User')['password'];

            $root = User::getUser(['email' => $email, 'password' => $password], 'login');

            if($root)
            {
                $this->successLogin($root['auth_key']);
            }
            else
            {
                $exist = User::find()->where(['email' => $email, 'password' => md5($password)])->one();

                if($exist)
                {
                    if($exist['is_active'] == 1)
                    {
                        $auth_key = md5($email . Date('d.m.H.i.s'));

                        $exist->auth_key = $auth_key;

                        if($exist->save())
                        {
                            $this->successLogin($auth_key);
                        }
                    }
                    else
                    {
                        $err = 'Your account is need activate!';
                    }

                }
                else
                {
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

        if($exist)
        {
            $exist->is_active = 1;
            $exist->token_activate = '';

            if($exist->save())
                $success = true;
        }

        return $this->render('activate', ['success' => $success]);
    }


    public function actionRegister()
    {
        $model = new User();
        $success = '';
        $err = '';

        if($model->load(Yii::$app->request->post()))
        {
            if(Yii::$app->request->post('User')['password'] != Yii::$app->request->post('r_password'))
                $err = 'Repeat password incorrect';
            else if(!User::find()->where(['email' => Yii::$app->request->post('User')['email']])->one())
            {
                $model->date_create = Date('d.m.Y - H:i');
                $model->password = md5($model->password);
                $model->token_activate = md5(time() . $model->email);

                if($model->save())
                {
                    $model->password = '';
                    $success = 'Register success. Please check your email and activate account';
                    $this->sendMail($model->email, $model->token_activate);
                }

            }
            else
                $err = 'This email is already';
        }

        return $this->render('register', ['model' => $model, 'success' => $success, 'err' => $err]);
    }

    private function sendMail($email, $token)
    {
        $to = $email;
        $from = 'noreply-activate@cs43884.tw1.ru';

        $subject = "Activate your account";
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/html; charset=utf-8\r\n";


        $message = '
            <h1>Activate account please open link</h1>
            <a href="http://cs43884.tw1.ru/web/user/activate?t=' . $token . '">Press activate link</a>
        ';

        mail($to, $subject, $message, $headers);
    }
}
