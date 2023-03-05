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

<!--    <p>-->
<!--        --><?//= Html::a('Create Requests', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            [
                'label' => 'Дата, час подачі',
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y / t:m']
            ],
            'child_name',
            [
                'label' => 'Дата рождения',
                'attribute' => 'birth_date',
                'format' => ['date', 'php:d.m.Y']
            ],
            'kindergarten.name',
//            [
//                'attribute' => 'kindergarten',
//                'value' => function ($model) {
//                    return $model->kindergarten->name;
//                },
//            ],
            'user.full_name',
            [
                'attribute' => 'status',
                'filter' => $searchModel->statusArr,
                'value' => function ($model) {
                    return $model->statusName;
                },
            ],
            'reason:ntext',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, Requests $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id, 'kindergarten_id' => $model->kindergarten_id, 'user_id' => $model->user_id]);
//                 }
//            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
