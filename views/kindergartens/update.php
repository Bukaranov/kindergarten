<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kindergartens $model */

$this->title = 'Оновити дитячі садки: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дитячі садки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'kindergarten_id' => $model->kindergarten_id]];
$this->params['breadcrumbs'][] = 'Оновлення';
?>
<div class="kindergartens-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
