<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Periodo;
use app\models\Semana;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

<!-- INICIO DO TESTE DE LAYOUT PARA HORÁRIO-->

<?php
$dias_da_semana = ArrayHelper::map(Semana::find()->all(), 'id', 'dia');
$periodos = ArrayHelper::map(Periodo::find()->all(), 'id', 'intervalo');
?>

<div class="container">
  <h2>Horário Turma ADS-2017.1</h2>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
      	<th><span class="glyphicon glyphicon-time"></span></th>
        <?php foreach ($dias_da_semana as $keyDia => $dia) { ?>
            <th><?= $dia ?></th>
        <?php }?>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($periodos as $keyPeriodo => $periodo) { ?>
            <tr>
              <th><?= $periodo ?></th>
              <?php foreach ($dias_da_semana as $keyDia => $dia) { ?>
                  <td class="tdhover">
                      <span id="<?= 'span'.$keyDia.$keyPeriodo ?>">
                          Nome da Disciplina - Identificador da Sala
                      </span>
                      <a id="<?= 'link'.$keyDia.$keyPeriodo ?>" href="#" class="pull-right" data-toggle="modal" data-target="#myModal">
                          <span class="glyphicon glyphicon-pencil"></span>
                      </a>
                  </td>
              <?php }?>
            </tr>
        <?php }?>
    </tbody>
  </table>
</div>


<div class="container">
  <h2>Horário Turma ADS-2017.1</h2>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
      	<th><span class="glyphicon glyphicon-time"></span></th>
        <?php foreach ($dias_da_semana as $keyDia => $dia) { ?>
            <th><?= $dia ?></th>
        <?php }?>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($periodos as $keyPeriodo => $periodo) { ?>
            <tr>
              <th><?= $periodo ?></th>
              <?php foreach ($dias_da_semana as $keyDia => $dia) { ?>
                  <td class="tdhover">
                      <div id="div-link">
                          <a id="<?= 'link'.$keyDia.$keyPeriodo ?>" href="#" class="fill-div" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="Escolher Disciplina/Sala">

                          </a>
                      </div>
                  </td>
              <?php }?>
            </tr>
        <?php }?>
    </tbody>
  </table>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<style>
    #div-link {
        /*background-color: lightgrey;
        /*width: 100px;*/
        height: 50px;*/
    }
    a.fill-div {
        text-align: center;
        display: block;
        height: 100%;
        width: 100%;
        text-decoration: none;
    }
    .tdhover:hover {
        background-color: #d9d9d9;
    }
</style>


<!-- INICIO MODAL -->
<?php
    $formCreate = ActiveForm::begin([
                'method' => 'post',
                //'action' => ['site/create'],
                ]);
    Modal::begin([
        'header' => '<h3><span class="glyphicon glyphicon-edit"></span> Escolha de Sala e Disciplina</h3>',
        'id' => 'myModal',
        'footer' => Html::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . Html::submitButton('Confirmar', ['class' => 'btn btn-primary'])
    ]);
?>
    <div class="rows">
        <label for="sel1">Sala:</label>
        <select class="form-control" id="sel1">
            <option>PGB-01</option>
            <option>PGB-02</option>
            <option>PGB-03</option>
            <option>PGB-04</option>
        </select>
    </div>
    <br>
    <div class="rows">
        <label for="dis">Disciplina:</label>
        <select class="form-control" id="dis">
            <option>Implementação de Banco de Dados</option>
            <option>Programação para Internet</option>
        </select>
    </div>
    <br>
    <div class="rows">
        <label for="map">Mapa das Salas:</label>
        <span id="map" class="glyphicon glyphicon-map-marker"></span>
    </div>
<?php
    Modal::end();
    ActiveForm::end();
?>
<!-- FIM MODAL -->


<!-- FIM DO TESTE DE LAYOUT PARA HORÁRIO-->

</div>
