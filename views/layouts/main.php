<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => [
//            ['label' => 'Home', 'url' => ['/site/index']],
            [
                'label' => 'Дитячі садки',
                'url' => ['/kindergartens/index'],
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
            ],
            [
                'label' => 'Запити',
                'url' => ['/requests/index'],
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
            ],
            [
                'label' => 'Користувачі',
                'url' => ['/users/index'],
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
            ],
//            ['label' => 'Авторизоваться', 'url' => ['/auth/login']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Авторизуватися', 'url' => ['/auth/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/auth/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Вийти (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
            [
                'label' => 'Реєстрація',
                'url' => ['/auth/signup'],
                'visible' => Yii::$app->user->isGuest
            ]
        ],
    ]);
    NavBar::end();

    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!--<footer class="footer mt-auto py-3 text-muted">-->
<!--    <div class="container">-->
<!--        <p class="float-left">&copy; My Company --><?//= date('Y') ?><!--</p>-->
<!--        <p class="float-right">--><?//= Yii::powered() ?><!--</p>-->
<!--    </div>-->
<!--</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
