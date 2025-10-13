<?php

namespace backend\controllers;

use backend\models\SignupForm;
use common\models\User;
use yii\db\Exception;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use Yii;
use yii\web\Cookie;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:8080'], // Allow this specific origin
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'], // Allow any headers
                'Access-Control-Max-Age' => 86400, // Optional: max duration of preflight cache
            ],
        ];

        return $behaviors;
    }

    public function actionLogin(){


        $request = Yii::$app->request;
        $post = $request->post();


        $identity = User::findOne(['username'=>$post['username']]);

        $identity->validatePassword($post['password']);

        if(!$identity){
            throw new Exception('User is not authentificated');
        }

        Yii::$app->user->login($identity);

        return $identity->access_token;
    }

    public function actionSignup(){

        $form = new SignupForm();

        $form->username = 'translator1';
        $form->email = 'translator1@mail.ru';
        $form->password = '12345678';

        return $form->signup();

    }

}