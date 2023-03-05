<?php

use app\models\Kindergartens;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Requests $model */

$this->title = 'Надіслати заяву';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="requests-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'child_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birth_date')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]) ?>


        <?=
        $form->field($model, 'kindergarten_id')->dropDownList(Kindergartens::getList())
        ?>

        <div class="form-group">
            <?= Html::submitButton('Відправити', ['class' => 'btn btn-success'])?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
