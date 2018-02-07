<?php

use common\models\Dishes;
use common\models\Ingredients;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DishesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блюда';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить блюдо', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'ingredients',
                'value' => function ($model) {
                    /* @var $model Dishes */
                    return implode(', ', ArrayHelper::map($model->ingredients, 'id', 'title'));
                },
                'filter' => Ingredients::find()->select(['title', 'id'])->indexBy('id')->column(),
            ],
            [
                'format' => 'html',
                'attribute' => 'active',
                'filter'  => ["0" => "Нет", "1" => "Да"],
                'value' => function ($model) {
                    /* @var $model Dishes */
                    switch ($model->active) {
                        case 0:
                            return \yii\helpers\Html::tag('span', 'Нет',
                                [
                                    'class' => 'label label-' . ('danger')
                                ]);
                            break;
                        case 1:
                            return \yii\helpers\Html::tag('span', 'Да',
                                [
                                    'class' => 'label label-' . ('success')
                                ]);
                            break;
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
