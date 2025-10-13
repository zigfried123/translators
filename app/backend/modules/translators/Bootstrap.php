<?php

namespace backend\modules\translators;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'default'],
                'translators' => 'translators/default/list',
            ]
        );
    }
}