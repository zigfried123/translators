<?php

use yii\db\Migration;

class m251013_064208_create_table_translators extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('translators', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'weekdays' => $this->boolean(),
            'worktime' => $this->json()
        ]);
    }

    public function down()
    {
        $this->dropTable('translators');

        return false;
    }
}
