<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Reviews;


class ReviewsController extends Controller
{
    static function getModel()
    {
        return new Reviews();
    }

    static function getUserReviews($exist = null)
    {
        return Reviews::find()->where(['id_author' => $exist['uid']])->orderBy(['id' => SORT_DESC])->asArray()->all();
    }

    static function getReview($exist = null)
    {
        return Reviews::find()->where(['id' => Yii::$app->request->get('id'), 'id_author' => $exist['uid']])->one();
    }


    static function add($exist = null)
    {
        $model = self::getModel();

        if ($model->load(Yii::$app->request->post())) {
            $model->date_create = Date('d.m.Y - H:i');
            $model->id_author = $exist['uid'];

            $filename = '';

            if (!empty($_FILES['Reviews']['name']['img'])) {
                $ext = strtolower(array_pop(explode('.', $_FILES['Reviews']['name']['img'])));
                $filename = 'file' . time() . '.' . $ext;

                move_uploaded_file($_FILES['Reviews']['tmp_name']['img'], '../upload/' . $filename);
            }

            $model->img = $filename;

            if($model->save())
                return 'ok';
            else
                return 'err';

        }

    }

    static function edit($exist = null)
    {
        $model = self::getReview($exist);

        $filename =  $model->img;

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_FILES['Reviews']['name']['img'])) {

                if ($filename)
                    unlink('../upload/' . $filename);

                $ext = strtolower(array_pop(explode('.', $_FILES['Reviews']['name']['img'])));
                $filename = 'file' . time() . '.' . $ext;

                move_uploaded_file($_FILES['Reviews']['tmp_name']['img'], '../upload/' . $filename);
            }

            $model->img = $filename;

            if($model->save())
                return 'ok';
            else
                return 'err';
        }
    }

    static function delete($exist)
    {
        if (Yii::$app->request->post('id')) {
            $model = Reviews::find()->where(['id' => Yii::$app->request->post('id'), 'id_author' => $exist['uid']])->one();

            if ($model->delete())
                return 'ok';
            else
                return 'err';
        }
    }
}
