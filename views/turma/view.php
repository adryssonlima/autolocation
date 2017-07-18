<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Turma */
//echo"<pre>";var_dump($model);
//echo"<pre>";var_dump($horario);

//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-view">

    <h2><i class='fa fa-eye' aria-hidden='true'></i> Visualizar Turma <span class="pull-right"><button class="btn btn-primary print" onClick="window.print();"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button></span></h2>
        
    <br>
    <div class="row">
        <div class="col-md-6">
            <span class="font-size">Identificador:</span> <span class="font-color" id="span-identificador"><?= $model[0]['identificador'] ?></span>
        </div>
        <div class="col-md-6">
            <span class="font-size">Curso:</span> <span class="font-color" id="span-curso"><?= $model[0]['curso'] ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <span class="font-size">Semestre Atual da Turma:</span> <span class="font-color" id="span-semestre"><?= $model[0]['semestre'] ?></span>
        </div>
        <div class="col-md-6">
            <span class="font-size">Turno:</span> <span class="font-color" id="span-turno"><?= $model[0]['turno'] ?></span>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <span class="font-size">Quadro de Horários da Turma:</span><br><br>
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
    </div>

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
            $('#th-dias-da-semana').append("<th class='table-horario th-center'>" + dia['dia'] + "</th>");
        });
        $("#tbody-periodos").empty();
        $.each(periodos, function(keyPeriodo, periodo) {
            $('#tbody-periodos').append("<tr id='" + periodo['id'] + "'><th class='th-center'>" + periodo['identificador'] + "<br>" + periodo['intervalo'] + "</th></tr>");
            $.each(dias_da_semana, function(keyDia, dia) {
                $('#'+periodo['id']).append("<td id='td" + dia['id']+periodo['id'] + "' class='tdhover'> <span class='info-turma-disciplina-sala' id='span" + dia['id']+periodo['id'] + "'></span> </td>");
            });
        });

        let horario = $.parseJSON('<?= $horario ?>');
        preencheTabelaHorario(horario);
    }

    function preencheTabelaHorario(horario) { //Pega os dados de horários da turma e preenche a tabela
        horario.forEach(function(val) {
            //console.log(val);
            $("#td"+val.semana+val.periodo).find("#span"+val.semana+val.periodo).html(val.nome_disciplina+"<br>"+val.identificador_sala);
            $("#td"+val.semana+val.periodo).css('text-align','center');                        
        });
    }

</script>

<style>
    .tdhover:hover {
        background-color: #d9d9d9;
    }
    th.th-center {
        text-align: center;
    }
    .font-size {
        font-size: 25px;
    }
    .font-color {
        color: #337ab7;
        font-size: 20px;
        font-weight: bold;
    }
</style>