<?php

namespace backend\modules\translators\models;

/**
 * This is the ActiveQuery class for [[Translators]].
 *
 * @see Translators
 */
class TranslatorsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Translators[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Translators|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
