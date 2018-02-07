<?php

namespace common\models\queries;

/**
 * This is the ActiveQuery class for [[\common\models\Ingredients]].
 *
 * @see \common\models\Ingredients
 */
class IngredientsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[active]]=1');
    }

    /**
     * @inheritdoc
     * @return \common\models\Ingredients[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Ingredients|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
