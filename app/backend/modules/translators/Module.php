<?php

namespace backend\modules\translators;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;

        \Yii::configure($this, require __DIR__ . '/config.php');
    }
}