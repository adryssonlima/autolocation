<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <div class="row">
        <h1 style="float:left;"><i class="fa fa-user-circle" aria-hidden="true"></i> <?= Html::encode($this->title) ?></span>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12 painel-titulo">
            <div class="col-md-8">
                <button type="button" class="btn btn-success new"><i class="fa fa-user-circle" aria-hidden="true"></i> Novo Usuário</button>
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
                  'attribute' => 'email',
                  'value' => 'email',
                  'enableSorting' => false,
                ],
                [
                  'attribute' => 'tipo',
                  'value' => 'tipo',
                  'enableSorting' => false,
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url) {
                            return "<i class='fa fa-pencil-square-o fa-lg color-green text-primary update clicavel' url='" . $url . "' aria-hidden='true'></i>";
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

<?php
Modal::begin([
    "header" => "<h3 class='modal-titulo'></h3>",
    "id" => "modal"
]);
echo "<div class='modal-conteudo'></div>";
Modal::end();
?>

<script>

    $(".new").click(function(){
        var url = "<?= Yii::$app->request->baseUrl . '/usuario/create' ?>";
        var titulo = "<i class='fa fa-user-circle' aria-hidden='true'></i> Novo Usuário";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

    $(".update").click(function(){
        var url = $(this).attr("url");
        var titulo = "<i class='fa fa-pencil-square-o' aria-hidden='true'></i> Alterar Usuário";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

    $(".delete").click(function(){
        var url = $(this).attr("url");
        var titulo = "<i class='fa fa-trash-o aria-hidden='true'></i> Remover Usuário";
        var csrftoken = "<?= Yii::$app->request->getCsrfToken() ?>";
        modalAjax(url, titulo, csrftoken);
    });

</script>