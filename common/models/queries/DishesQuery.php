<?php

namespace common\models\queries;

/**
 * This is the ActiveQuery class for [[\common\models\Dishes]].
 *
 * @see \common\models\Dishes
 */
class DishesQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[active]]=1');
    }

    /**
     * @inheritdoc
     * @return \common\models\Dishes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Dishes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
