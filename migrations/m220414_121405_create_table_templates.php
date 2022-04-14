<?php

use yii\db\Migration;

/**
 * Class m220414_121405_create_table_templates
 */
class m220414_121405_create_table_templates extends Migration
{

    public function safeUp()
    {
        $this->createTable('templates', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'deleted' => $this->boolean(false)->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-templates-user_id',
            'templates',
            'user_id'
        );

        $this->addForeignKey(
            'fk-templates-user_id',
            'templates',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }

}
