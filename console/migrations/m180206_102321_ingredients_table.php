<?php

use yii\db\Migration;

/**
 * Class m180206_102321_ingredients_table
 */
class m180206_102321_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     *//*
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'active' => $this->integer()->defaultValue('1'),
        ], $tableOptions);
/*
        $this->insert('ingredients', [
            'title' => 'test 1',
            'content' => 'content 1',
        ]);*/
   /* }

    /**
     * @inheritdoc
     *//*
    public function safeDown()
    {
        $this->dropTable('ingredients');

        return false;
    }
*/

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'active' => $this->integer()->defaultValue('1'),
        ], $tableOptions);
        /*
                $this->insert('ingredients', [
                    'title' => 'test 1',
                    'content' => 'content 1',
                ]);*/
    }

    public function down()
    {
        $this->dropTable('ingredients');

        return false;
    }

}
