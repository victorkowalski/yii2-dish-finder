<?php

use yii\db\Migration;

/**
 * Class m180206_102657_dishes_table
 */
class m180206_102657_dishes_table extends Migration
{
    /**
     * @inheritdoc
     *//*
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dishes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'active' => $this->integer()->defaultValue('1'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     *//*
    public function safeDown()
    {
        $this->dropTable('dishes');

        return false;
    }
*/

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dishes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'active' => $this->integer()->defaultValue('1'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('dishes');

        return false;
    }

}
