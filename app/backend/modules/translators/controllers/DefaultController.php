<?php

namespace backend\modules\translators\controllers;

use yii\rest\ActiveController;

class DefaultController extends ActiveController
{
    public $modelClass = 'backend\modules\translators\models\Translators';

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

    public function actionList()
    {
      return '1';
    }
}