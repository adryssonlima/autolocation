<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Curso;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turmas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-index">

    <div class="row">
        <h1 style="float:left;"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?= Html::encode($this->title) ?></span>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12 painel-titulo">
            <div class="col-md-8">
                <?= Html::a('<i class="fa fa-graduation-cap" aria-hidden="true"></i> Nova Turma', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-md-4">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            //'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => "table table-striped"
            ],
            'columns' => [
                [
                  'attribute' => 'identificador',
                  'value' => 'identificador',
                  'enableSorting' => false,
                ],
                [
                  'attribute' => 'curso',
                  'value' => function ($dataProvider) {
                      return Curso::find()->select(['nome'])->where(['id' => $dataProvider->curso])->one()['nome'];
                  },
                  'enableSorting' => false,
                ],
                [
                  'attribute' => 'semestre',
                  'value' => 'semestre',
                  'enableSorting' => false,
                ],
                [
                  'attribute' => 'turno',
                  'value' => 'turno',
                  'enableSorting' => false,
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url) {
                            return "<i class='fa fa-eye fa-lg color-green text-success view clicavel' url='" . $url . "' aria-hidden='true'></i>";
                        },
                        'update' => function ($url) {
                            return "<a href='" . $url . "' ><i class='fa fa-pencil-square-o fa-lg color-green text-primary' aria-hidden='true'></i></a>";
                        },
                        'delete' => function ($id) {
                            return "<i class='fa fa-trash-o fa-lg delete text-danger clicavel' url='" . $id . "' aria-hidden='true'></i>";
                        }
                    ]
                ],
            ]
        ]);
        ?>
    </div>

</div>
