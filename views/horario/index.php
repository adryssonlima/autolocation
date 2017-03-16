<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

$dias_da_semana = ['1' => 'Segunda-Feira', '2' => 'Terça-Feira', '3' => 'Quarta-Feira', '4' => 'Quinta-Feira', '5' => 'Sexta-Feira'];
$horarios = ['1' => '7:30 às 9:10', '2' => '9:20 às 11:00', '3' => '11:00 às 12:50'];

?>

<div class="container">
  <h2>Horário Tura ADS-2017.1</h2>
  <!--<p>The .table-bordered class adds borders to a table:</p> -->
  <table class="table table-bordered">
    <thead>
      <tr>
      	<th>Horário</th>
        <?php foreach ($dias_da_semana as $key => $value) { ?>
            <th><?= $value ?></th>
        <?php }?>
      </tr>
    </thead>
    <tbody>
        
    </tbody>
  </table>
</div>




<div class="container">
  <h2>Horário Tura ADS-2017.1</h2>
  <!--<p>The .table-bordered class adds borders to a table:</p> -->
  <table class="table table-bordered">
    <thead>
      <tr>
      	<th>Horário</th>
        <th>Segunda</th>
        <th>Terça</th>
        <th>Quarta</th>
        <th>Quinta</th>
        <th>Sexta</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>AB</th>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span> </span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span> </span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
      </tr>
      <tr>
        <th>CD</th>
		<td><span> </span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span> </span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
      </tr>
      <tr>
        <th>EF</th>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span> </span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><span>Disciplina - Sala</span><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></a></td>
      </tr>
    </tbody>
  </table>
</div>







<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preencha os campos:</h4>
        </div>
        <div class="modal-body">
			<div class="form-group">
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
					<label for="map">Mapa das Sala:</label>
					<span id="map" class="glyphicon glyphicon-map-marker"></span>
				</div>
			</div>
		</div>
		<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
        </div>

      </div>
    </div>
</div>


<!-- FIM DO TESTE DE LAYOUT PARA HORÁRIO-->









</div>
