<?php

namespace backend\controllers;

use backend\models\SignupForm;
use common\models\User;
use yii\db\Exception;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use Yii;



class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173'], // Allow this specific origin
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'], // Allow any headers
                'Access-Control-Max-Age' => 86400, // Optional: max duration of preflight cache
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login', 'signup'],
        ];

        return $behaviors;
    }

    public function actionLogin(){


        $request = Yii::$app->request;
        $post = $request->post();


        $identity = User::findOne(['username'=>$post['username']]);

        if(!$identity){
            throw new Exception('User not found');
        }

        if(!$identity->validatePassword($post['password'])){
            throw new Exception('User not authentificated');
        }

        $auth = Yii::$app->authManager;

        return ['token' => $identity->access_token, 'roles' => array_keys($auth->getRolesByUser($identity->getId()))];
    }

    public function actionLogout(){

        $request = Yii::$app->request;

        $token = explode(' ', $request->headers['Authorization'])[1];

        $user = User::findIdentityByAccessToken($token);

        if($user) {
            return true;
        }

        return false;
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

        $token = explode(' ', $request->headers['Authorization'])[1];

        $user = User::findIdentityByAccessToken($token);

        $roles = array_keys($auth->getRolesByUser($user->getId()));

        $data = ['username' => $user->username, 'roles' => $roles];
        if($user->translator) {
            $user->translator->worktime = json_decode($user->translator->worktime);
            $data['translator'] = $user->translator;
        }

        return $data;

    }

}