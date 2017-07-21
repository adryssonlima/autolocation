<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Curso;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

date_default_timezone_set('America/Fortaleza');

$this->title = 'Turmas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-index">

    <div class="row">
        <div class="col-md-6">
            <h1 style="float:left;"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?= Html::encode($this->title) ?></span></h1>
        </div>
        <div class="col-md-6">
            <div class="alert alert-success" role="alert">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                As Turmas com data de modificação em cor verde significam que foram alteradas nos últimos 2 meses.
            </div>
        </div>
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
                [
                  'attribute' => 'last_update',
                  'format' => 'raw',
                  'value' => function ($dataProvider) {
                        $dateNow = new DateTime(date('Y-m-d'));
                        $last_update = new DateTime($dataProvider->last_update);
                        $diff = $dateNow->diff($last_update);
                        if ($diff->m <= 2) {
                            return Html::decode('<span class="label label-success">' . $last_update->format('d/m/Y') . '</span>');
                        }
                        return $last_update->format('d/m/Y');
                  },
                  'enableSorting' => false,
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url) {
                            return "<a href='".$url."' title='Visualizar'><i class='fa fa-eye fa-lg text-success' aria-hidden='true'></i></a>";
                        },
                        'update' => function ($url) {
                            return "<a href='" . $url . "' title='Alterar' ><i class='fa fa-pencil-square-o fa-lg color-green text-primary' aria-hidden='true'></i></a>";
                        },
                        'delete' => function ($id) {
                            return "<a href='".$id."' data-method='post' title='Excluir' ><i class='fa fa-trash-o fa-lg delete text-danger clicavel' aria-hidden='true'></i></a>";
                        }
                    ]
                ],
            ]
        ]);
        ?>
    </div>

</div>