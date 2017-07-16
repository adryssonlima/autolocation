<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Turma */
//echo"<pre>";var_dump($model);
//echo"<pre>";var_dump($horario);

//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-view">

    <div class="row">
        <div class="col-md-6">
            <b>Identificador:</b> <span id="span-identificador"><?= $model[0]['identificador'] ?></span>
        </div>
        <div class="col-md-6">
            <b>Curso:</b> <span id="span-curso"><?= $model[0]['curso'] ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <b>Semestre Atual da Turma:</b> <span id="span-semestre"><?= $model[0]['semestre'] ?></span>
        </div>
        <div class="col-md-6">
            <b>Turno:</b> <span id="span-turno"><?= $model[0]['turno'] ?></span>
        </div>
    </div>
    <br>

    <div class="row">
        <h3>Quadro de Horários da Turma</h3><br>
        <div id="div-table-horario">
            <table id="table-horario" class="table table-bordered table-striped table-hover">
                <thead>
                <tr id="th-dias-da-semana">

                </tr>
                </thead>
                <tbody id="tbody-periodos">

                </tbody>
            </table>
        </div>
    </div>

    <!--
    <div class="row">
        <ul class="list-inline pull-right">
            <li><button id="btn-conf-voltar" type="button" class="btn btn-default prev-step"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</button></li>
            <li><button id="btn-finalizar" type="button" class="btn btn-primary next-step">Finalizar <i class="glyphicon glyphicon-ok"></i></button></li>
        </ul>
    </div>Manhã
    -->

</div>

<script>

    $(document).ready(function(){
        let turno = '<?= $model[0]['turno'] ?>';
        createTabelaHorario(turno.charAt(0));
    });

    function createTabelaHorario(turno) { //Cria a tabela de horáarios dinamicamente com base no turno da turma
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/get-dias-periodos' ?>',
            type: 'post',
            data: {
                turno: turno
            },
            success: function (data) {
                var dados = $.parseJSON(data);
                var dias_da_semana = dados['dias'];
                var periodos = dados['periodos'];

                montaTabelaHorario(dias_da_semana, periodos);

            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function montaTabelaHorario(dias_da_semana, periodos) {
        $("#th-dias-da-semana").empty();
        $('#th-dias-da-semana').append("<th class='th-center'><span class='glyphicon glyphicon-time'></span></th>");
        $.each(dias_da_semana, function(keyDia, dia) {
            $('#th-dias-da-semana').append("<th class='th-center'>" + dia['dia'] + "</th>");
        });
        $("#tbody-periodos").empty();
        $.each(periodos, function(keyPeriodo, periodo) {
            $('#tbody-periodos').append("<tr id='" + periodo['id'] + "'><th class='th-center'>" + periodo['identificador'] + "<br>" + periodo['intervalo'] + "</th></tr>");
            $.each(dias_da_semana, function(keyDia, dia) {
                $('#'+periodo['id']).append("<td id='td" + dia['id']+periodo['id'] + "' class='tdhover'> <span class='info-turma-disciplina-sala' id='span" + dia['id']+periodo['id'] + "'></span> <a id='link" + dia['id']+periodo['id'] + "' id_dia='" + dia['id'] + "' id_periodo='" + periodo['id'] + "' href='#' class='pull-right text-success' title='Editar'> <span class='glyphicon glyphicon-pencil'></span> </a> </td>");
            });
        });
    }

</script>