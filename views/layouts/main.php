<?php

/* @var $this View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= Yii::$app->request->baseUrl ?>/web/js/jquery-3.1.1.min.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/web/js/functions.js"></script>
    <script src="<?= Yii::$app->request->baseUrl ?>/web/js/vue.min.js"></script>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/web/css/style-wizard-circular.css">
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/web/font-awesome-4.7.0/css/font-awesome.min.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Auto Location',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
		'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '<i class="fa fa-table" aria-hidden="true"></i>&nbsp;Painel de Turmas', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            //['label' => 'Contact', 'url' => ['/site/contact']],
			['label' => '<i class="fa fa-university" aria-hidden="true"></i>&nbsp;Cursos', 'url' => ['/curso']],
			['label' => '<i class="fa fa-book" aria-hidden="true"></i>&nbsp;Disciplinas', 'url' => ['/disciplina']],
			['label' => '<i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp;Salas', 'url' => ['/sala']],
			['label' => '<i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Períodos', 'url' => ['/periodo']],
			['label' => '<i class="fa fa-graduation-cap" aria-hidden="true"></i>&nbsp;Turmas', 'url' => ['/turma']],
			['label' => '<i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;Usuários do Sistema', 'url' => ['/usuario']],
            Yii::$app->user->isGuest ? (
                ['label' => '<i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '<i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Sair (' . Yii::$app->user->identity->nome . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Auto Location <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
