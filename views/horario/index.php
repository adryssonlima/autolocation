<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Horarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Horario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= ''//GridView::widget([
//        'dataProvider' => $dataProvider,
//        //'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'turma',
//            'disciplina',
//            'semana',
//            'sala',
//            'periodo',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>

