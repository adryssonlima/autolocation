<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = 'Criar Turma';
//$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-create">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>

    $('#indisponiveis').click(function() {
        getHorariosOcupados();
    });

    $('#conf-dados-turma').click(function() {
        var turma = [
            $('#turma-identificador').val(),
            $('#turma-curso').val(),
            $('#turma-semestre').val(),
            $('#turma-turno').val()
        ];
        //createTurma(turma);
        createTabelaHorario(turma);
        getHorariosOcupados();
    });

    $("#table-horario").find("a").click(function(){
        console.log("clicou"); //NÃO ESTA PEGANDO O EVENTO DE CLICK DO LINK
        var dia = $(this).attr("id_dia");
        var periodo = $(this).attr("id_periodo");
        var curso = $("#turma-curso").val();
        var semestre = $("#turma-semestre").val();
        console.log(dia, periodo, curso, semestre);
        $("#dia-periodo").attr("dia", dia);
        $("#dia-periodo").attr("periodo", periodo);
        getSalasDisciplinas(dia, periodo, curso, semestre);

    });

    $(".modal-confirmar").click(function(){
        var dia = $("#dia-periodo").attr("dia");
        var periodo = $("#dia-periodo").attr("periodo");
        var sala = $("#modal-sala option:selected").val();
        var disciplina = $("#modal-disciplina option:selected").val();
        createHorario(dia, periodo, sala, disciplina);
    });
/*
    function createTurma(arrTurma) {
        $.ajax({
            url: '<?= ''//Yii::$app->request->baseUrl . '/?r=turma/nova-turma' ?>',
            type: 'post',
            data: {
                identificador: arrTurma[0],
                curso: arrTurma[1],
                semestre: arrTurma[2],
                turno: arrTurma[3]
            },
            success: function (data) {
                console.log(data);
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }
*/
    function createTabelaHorario(arrTurma) { //Cria a tabela de horáarios dinamicamente com base no turno da turma
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/?r=turma/get-dias-periodos' ?>',
            type: 'post',
            data: {
                turno: arrTurma[3]
            },
            success: function (data) {
                var dados = $.parseJSON(data);
                var dias_da_semana = dados['dias'];
                var periodos = dados['periodos'];

                $("#th-dias-da-semana").empty();
                $('#th-dias-da-semana').append("<th class='th-center'><span class='glyphicon glyphicon-time'></span></th>");
                $.each(dias_da_semana, function(keyDia, dia) {
                    $('#th-dias-da-semana').append("<th class='th-center'>" + dia['dia'] + "</th>");
                });
                $("#tbody-periodos").empty();
                $.each(periodos, function(keyPeriodo, periodo) {
                    $('#tbody-periodos').append("<tr id='" + periodo['id'] + "'><th class='th-center'>" + periodo['identificador'] + "<br>" + periodo['intervalo'] + "</th></tr>");
                    $.each(dias_da_semana, function(keyDia, dia) {
                        $('#'+periodo['id']).append("<td class='tdhover'> <span id='span" + dia['id']+periodo['id'] + "'></span> <a id='link" + dia['id']+periodo['id'] + "' id_dia='" + dia['id'] + "' id_periodo='" + periodo['id'] + "' href='#' class='pull-right' data-toggle='modal' data-target='#myModal'> <span class='glyphicon glyphicon-pencil'></span> </a> </td>");
                    });
                });
                console.log("Tabela Criada");
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    //setInterval(getHorariosOcupados,2000);

    function getHorariosOcupados() {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/?r=turma/horarios-ocupados' ?>',
            type: 'post',
            data: {
                id: null
            },
            success: function (data) {
                var dados = $.parseJSON(data);
                console.log(dados);
                $("#table-horario").find("span").text("");
                $.each(dados, function(index, value) {
                    $("#span"+value).text("Sem Salas Disponíveis").css('color', 'red');
                    $("#link"+value).remove();
                });
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function getSalasDisciplinas(dia, periodo, curso, semestre) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/?r=turma/get-salas-disciplinas' ?>',
            type: 'post',
            data: {
                id_dia: dia,
                id_periodo: periodo,
                id_curso: curso,
                semestre: semestre
            },
            success: function (data) {
                var dados = $.parseJSON(data);
                var salas = dados['salas'];
                var disciplinas = dados['disciplinas'];
                $("#modal-sala").empty();
                $.each(salas, function(index, value) {
                    $("#modal-sala").append($("<option></option>").attr("value", index).text(value));
                });
                $("#modal-disciplina").empty();
                $.each(disciplinas, function(index, value) {
                    $("#modal-disciplina").append($("<option></option>").attr("value", index).text(value));
                });
                console.log(dados);
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function createHorario(dia, periodo, sala, disciplina) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/?r=turma/create-horario' ?>',
            type: 'post',
            data: {
                dia: dia,
                periodo: periodo,
                sala: sala,
                disciplina: disciplina
            },
            success: function (data) {
                console.log(data);
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

</script>
