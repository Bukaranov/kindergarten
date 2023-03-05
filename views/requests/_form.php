<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Requests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="requests-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//= $form->field($model, 'child_name')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'birth_date')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'kindergarten_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'user_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'created_at')->textInput() ?>
<!---->
    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
