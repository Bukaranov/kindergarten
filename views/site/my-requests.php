<?php

use app\models\Requests;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\RequestsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Запити';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'child_name',
            [
                'label' => 'Дата народження',
                'attribute' => 'birth_date',
                'format' => ['date', 'php:d.m.Y']
            ],
            'kindergarten.name',
            [
                'label' => 'кол-во оставшихся мест',
                'value' => function ($model) {
                    return $model->kindergarten->capacity - $model->kindergarten->requestsCount;
                },
            ],
            [
                'label' => 'кол-вом заявок впереди',
                'value' => function ($model) {
                    return $model->previousCount;
                },
            ],
            [
                'attribute' => 'status',
                'filter' => $searchModel->statusArr,
                'value' => function ($model) {
                    return $model->statusName;
                },
            ],
            [
                'label' => 'Причина',
                'attribute' => 'reason',
            ],
            [
                'label' => 'Дата, час подачі',
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y / t:m']
            ],
            [
                'header' => 'Видалення',
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'visibleButtons'=>[
                    'delete'=> function($model) {
                          return $model->status == 1;
                     },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'delete') {
                        return Url::to(['site/delete-request', 'id' => $model->id]);
                    }
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
