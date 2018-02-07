<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Dishes */
/* @var $form yii\widgets\ActiveForm */
/* @var $data common\models\Ingredients[] */
?>

<div class="dishes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->checkbox(); ?>

    <?= $form->field($model, 'ingredientsArray')->widget(\kartik\select2\Select2::classname(), [
        'name' => 'ingredients',
        'language' => 'ru',
        'value' => $model->ingredients, // initial value (will be ordered accordingly and pushed to the top)
        'data' => $data,
        'maintainOrder' => true,
        'showToggleAll' => false,
        'toggleAllSettings' => [
            'unselectLabel' => '<i class="glyphicon glyphicon-remove-sign"></i> Убрать все',
            'unselectOptions' => ['class' => 'text-danger'],
        ],
        'options' => ['placeholder' => 'Выберите ингредиенты', 'multiple' => true],
        'pluginOptions' => [
            'tags' => false,
            'maximumSelectionLength' => 5,
        ],
    ])->label('Ингредиенты'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
