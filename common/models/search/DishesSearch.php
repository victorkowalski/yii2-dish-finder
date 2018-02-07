<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dishes;

/**
 * DishesSearch represents the model behind the search form about `common\models\Dishes`.
 */
class DishesSearch extends Dishes
{
    public $ingredients;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['title', 'ingredients'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dishes::find()->with('ingredients')->groupBy('title')->joinWith('ingredients');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->validate() && $this->load($params))) {
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'title',
                'active',
                'ingredients' => [
                    'asc' => ['dishes_ingredients.dish_id' => SORT_ASC],
                    'desc' => ['dishes_ingredients.dish_id' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]]);


        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.active' => $this->active,
            'dishes_ingredients.ingredient_id' => $this->ingredients,

        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        return $dataProvider;
    }
}
