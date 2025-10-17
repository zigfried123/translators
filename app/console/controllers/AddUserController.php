<?php

namespace console\controllers;

use backend\modules\translators\models\Translator;
use common\models\User;
use yii\console\Controller;
use Yii;

class AddUserController extends Controller
{
    public function actionIndex()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {

        $auth = Yii::$app->authManager;

        $translator = $auth->createRole('translator');
        $auth->add($translator);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $user = new User();
        $user->username = 'translator1';
        $user->email = 'translator1@mail.ru';
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();
        $user->save();

        $translatorModel = new Translator();
        $translatorModel->user_id = $user->id;
        $translatorModel->is_weekdays = 1;

        $translatorModel->save();

        $auth->assign($translator, $user->getId());


        $user = new User();
        $user->username = 'translator2';
        $user->email = 'translator2@mail.ru';
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();
        $user->save();

        $translatorModel = new Translator();
        $translatorModel->user_id = $user->id;
        $translatorModel->is_weekdays = 0;

        $translatorModel->save();

        $auth->assign($translator, $user->getId());

        $user = new User();
        $user->username = 'translator3';
        $user->email = 'translator3@mail.ru';
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();
        $user->save();

        $translatorModel = new Translator();
        $translatorModel->user_id = $user->id;
        $translatorModel->is_weekdays = 0;

        $translatorModel->save();

        $auth->assign($translator, $user->getId());

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@mail.ru';
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();
        $user->save();

        $auth->assign($admin, $user->getId());

        echo 'Пользователи созданы'.PHP_EOL;

            $transaction->commit();

        } catch(\Throwable $e) {
            $transaction->rollBack();
            echo "Ошибка транзакции ".$e->getMessage().PHP_EOL;
        }
    }

}