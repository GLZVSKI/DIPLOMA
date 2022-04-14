<?php

use yii\db\Migration;

/**
 * Class m220412_140944_create_table_users
 */
class m220412_140944_create_table_users extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->unique()->notNull(),
            'password' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->unique()->notNull(),
            'role' => $this->integer()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }
}
