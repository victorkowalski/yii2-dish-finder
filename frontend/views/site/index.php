<?php

/* @var $this yii\web\View */

use kartik\select2\Select2;
use yii\helpers\Html;

$this->title = 'Dish finder';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-md-4">
                <div class="site-dishes">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?= Select2::widget([
                        'name' => 'selected',
                        'language' => 'ru',
                        'id' => 'ingredient-select',
                        'data' => $ingredients,
                        'showToggleAll' => false,
                        'options' => ['placeholder' => 'Выберите ингредиент ...', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'maximumSelectionLength' => 5,
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="col-md-8">
                <div id="search-result"></div>
            </div>
        </div>

</div>
</div>
