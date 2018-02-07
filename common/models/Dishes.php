<?php

namespace common\models;

use common\models\queries\DishesQuery;
use Yii;

/**
 * This is the model class for table "dishes".
 *
 * @property integer $id
 * @property string $title
 * @property integer $active
 *
 * @property DishesIngredients[] $dishesIngredients
 * @property Ingredients[] $ingredients
 */
class Dishes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    private $_ingredientsArray;


    public static function tableName()
    {
        return 'dishes';
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
            [['title'], 'unique', 'message' => 'Блюдо с таким названием уже существует'],
            [['ingredientsArray'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'title' => 'Название блюда',
            'active' => 'Активно',
            'ingredients' => 'Ингредиенты',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->updateIngredients();
    }

    private function updateIngredients()
    {
        $currentIngredientsIds = $this->getIngredients()->select('id')->column();
        $newIngredientsIds = $this->getIngredientsArray();

        foreach (array_filter(array_diff($newIngredientsIds, $currentIngredientsIds)) as $IngredientId) {
            /** @var Ingredients $Ingredient */
            if ($Ingredient = Ingredients::findOne($IngredientId)) {
                $this->link('ingredients', $Ingredient);
            }
        }

        foreach (array_filter(array_diff($currentIngredientsIds, $newIngredientsIds)) as $IngredientId) {
            /** @var Ingredients $Category */
            if ($Ingredient = Ingredients::findOne($IngredientId)) {
                $this->unlink('ingredients', $Ingredient, true);
            }
        }
    }

    public function getIngredientsArray()
    {
        if ($this->_ingredientsArray === null) {
            $this->_ingredientsArray = $this->getIngredients()->select('id')->column();
        }
        return $this->_ingredientsArray;
    }

    public function setIngredientsArray($value)
    {
        $this->_ingredientsArray = (array)$value;

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishesIngredients::className(), ['dish_id' => 'id']);
    }

    public function getIngredients()
    {
        return $this->hasMany(Ingredients::className(), ['id' => 'ingredient_id'])->viaTable('dishes_ingredients', ['dish_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DishesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DishesQuery(get_called_class());
    }
}
