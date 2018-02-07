<?php

namespace common\models;

use common\models\queries\IngredientsQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ingredients".
 *
 * @property integer $id
 * @property string $title
 * @property integer $active
 *
 * @property DishesIngredients[] $dishesIngredients
 */
class Ingredients extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код ингредиента',
            'title' => 'Название ингредиента',
            'active' => 'Активно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishesIngredients::className(), ['ingredient_id' => 'id']);
    }

    public function getDishes()
    {
        return $this->hasMany(Dishes::className(), ['id' => 'dish_id'])->viaTable('dishes_ingredients', ['ingredient_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return IngredientsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IngredientsQuery(get_called_class());
    }
}
