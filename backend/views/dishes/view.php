<?php

use common\models\Dishes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Dishes */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Назад', 'index', ['class' => 'btn btn-default']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить блюдо "' . mb_strtolower($model->title, 'UTF-8') . '"?',
                'method' => 'post',
            ],
        ]) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'format' => 'html',
                'attribute' => 'active',
                'value' => call_user_func(function ($model) {
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
                }, $model)
            ],
            [
                'attribute' => 'ingredients',
                'value' => function ($model) {
                    /* @var $model Dishes */
                    return implode(', ', ArrayHelper::map($model->ingredients, 'id', 'title'));
                },
            ],
        ],
    ]) ?>

</div>
