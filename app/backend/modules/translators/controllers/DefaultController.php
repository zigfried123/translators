<?php

namespace backend\modules\translators\controllers;

use backend\modules\translators\models\Translator;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use Yii;

class DefaultController extends ActiveController
{
    public $modelClass = 'backend\modules\translators\models\Translators';

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
        ];

        $behaviors['authenticator']['except'] = ['options'];



        return $behaviors;
    }
    public function actionSetSchedule()
    {
        $post = Yii::$app->request->post();

        $translator = Translator::findOne(['id'=>$post['translatorId']]);

        $translator->worktime = json_encode($post['daysObjs']);
        $translator->is_weekdays = $post['is_weekdays'];

        $translator->save();

        return $translator;
    }

    public function actionGetTranslatorsData()
    {
        $translators = Translator::find()->joinWith('user')->all();

        $data = [];

        foreach ($translators as $translator) {

            $data[] = [
                'id' => $translator->id,
                'is_weekdays' => $translator->is_weekdays,
                'worktime' => json_decode($translator->worktime),
                'username' => $translator->user->username
            ];

        }

        return $data;
    }

}