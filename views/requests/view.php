<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Requests $model */

$this->title = $model->child_name;
$this->params['breadcrumbs'][] = ['label' => 'Запити', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="requests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Прийняти', ['accept', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Відмовити', [
            'class' => 'btn btn-danger',
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'child_name',
            'birth_date',
            'kindergarten.name',
            'user.full_name',
//            'statusName',
            [
                'label' => 'Статус',
                'attribute' => 'statusName',
            ],
            'reason:ntext',
            'created_at',
        ],
    ]) ?>

    <?php Modal::begin([
        'id' => 'myModal',
        'header' => '<h2>Відмовити</h2>',
    ]);

    $form = ActiveForm::begin([
        'action' => ['refusal', 'id' => $model->id],
    ]); ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Відмовити', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Modal::end(); ?>


</div>
