<?php

use yii\db\Migration;

/**
 * Class m180206_102935_dishes_ingredients_table
 */
class m180206_102935_dishes_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    /*
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dishes_ingredients}}', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_to_dishes', 'dishes_ingredients', 'dish_id', 'dishes', 'id');
        $this->addForeignKey('fk_to_ingredients', 'dishes_ingredients', 'ingredient_id', 'ingredients', 'id');
    }

    /**
     * @inheritdoc
     *//*
    public function safeDown()
    {
        $this->dropForeignKey('fk_to_dishes', 'dishes_ingredients');
        $this->dropForeignKey('fk_to_ingredients', 'dishes_ingredients');
        $this->dropTable('dishes_ingredients');

        return false;
    }
*/

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dishes_ingredients}}', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_to_dishes', 'dishes_ingredients', 'dish_id', 'dishes', 'id');
        $this->addForeignKey('fk_to_ingredients', 'dishes_ingredients', 'ingredient_id', 'ingredients', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_to_dishes', 'dishes_ingredients');
        $this->dropForeignKey('fk_to_ingredients', 'dishes_ingredients');
        $this->dropTable('dishes_ingredients');

        return false;
    }

}
