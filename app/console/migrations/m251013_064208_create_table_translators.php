<?php

use yii\db\Migration;

class m251013_064208_create_table_translators extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('translator', [
            'id' => $this->primaryKey(),
            'weekdays' => $this->boolean()->notNull(),
            'worktime' => 'JSON NOT NULL',
            'user_id' => $this->integer()->notNull()->unique()
        ]);

        $this->addForeignKey('fk_user_user_id','translator','user_id', 'user','id','CASCADE','RESTRICT');
    }

    public function down()
    {
        $this->dropTable('translator');

        return false;
    }
}
