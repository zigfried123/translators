<?php

namespace backend\modules\translators\models;

use Yii;

/**
 * This is the model class for table "translators".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $weekdays
 * @property string|null $worktime
 */
class Translators extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'weekdays', 'worktime'], 'default', 'value' => null],
            [['weekdays'], 'boolean'],
            [['worktime'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'weekdays' => 'Weekdays',
            'worktime' => 'Worktime',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TranslatorsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TranslatorsQuery(get_called_class());
    }

}
