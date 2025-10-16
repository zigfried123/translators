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


        return $behaviors;
    }
    public function actionSetSchedule()
    {
        $post = Yii::$app->request->post();

        $translator = Translator::findOne(['id'=>$post['translatorId']]);

        $translator->worktime = json_encode($post['daysObjs']);
        $translator->weekdays = $post['weekdays'];

        $translator->save();

        return $translator;
    }
}