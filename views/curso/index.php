<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cursos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-index">

    <div class="row">
        <h1 style="float:left;"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?= Html::encode($this->title) ?></span>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12 painel-titulo">
            <div class="col-md-8">
                <!--<button type="button" class="btn btn-success new"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Novo Curso</button>-->
                <?= Html::a('<i class="fa fa-graduation-cap" aria-hidden="true"></i> Novo Curso', ['create'], ['class' => 'btn btn-success']) ?>
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
                  'attribute' => 'nome',
                  'value' => 'nome',
                  'enableSorting' => false,
                ],
                [
                  'attribute' => 'qtd_semestre',
                  'value' => 'qtd_semestre',
                  'enableSorting' => false,
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url) {
                            return "<a href='".$url."' title='Editar'><i class='fa fa-pencil-square-o fa-lg text-primary' aria-hidden='true'></i></a>";
                        },
                        'delete' => function ($url) {
                            return "<a href='".$url."' title='Excluir'><i class='fa fa-trash-o fa-lg text-danger' aria-hidden='true'></i></a>";
                        }
                    ]
                ],
            ]
        ]);
        ?>
    </div>
</div>
