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
                'Origin' => ['http://localhost:5173'], // Allow this specific origin
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

        $auth = Yii::$app->authManager;

        return ['token' => $identity->access_token, 'roles' => array_keys($auth->getRolesByUser($identity->getId()))];
    }

    public function actionSignup(){

        $form = new SignupForm();

        $form->username = 'translator1';
        $form->email = 'translator1@mail.ru';
        $form->password = '12345678';

        return $form->signup();

    }

    public function actionUserdataByToken(){

        $auth = Yii::$app->authManager;


        $request = Yii::$app->request;
        $post = $request->post();
        $token = $post['token'];

        $user = User::findIdentityByAccessToken($token);

        $roles = array_keys($auth->getRolesByUser($user->getId()));


        $data = ['user' => $user->username, 'roles' => $roles];
        if($user->translator) {
            $data['translator'] = $user->translator;
        }

        return $data;

    }

}