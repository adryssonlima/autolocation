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
        createTurma(turma);
        getHorariosOcupados();
    });

    $("#table-horario").find("a").click(function(){
        var dia = $(this).attr("id_dia");
        var periodo = $(this).attr("id_periodo");
        var curso = $("#turma-curso").val();
        var semestre = $("#turma-semestre").val();
        $("#dia-periodo").val(dia+periodo);
        getSalasDisciplinas(dia, periodo, curso, semestre);
        //console.log(dia, periodo, curso);
    });

    $(".modal-confirmar").click(function(){
        var sala = $("#modal-sala option:selected").val();
        var disciplina = $("#modal-disciplina option:selected").val();
        var id_span = "#span" + $("#dia-periodo").val();
        $(id_span).text(disciplina + " / " + sala);
        //createHorario(sala, disciplina);
    });

    function createTurma(arrTurma) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/?r=turma/nova-turma' ?>',
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
                $("#table-horario").find("span").text("");
                $.each(dados, function(index, value) {
                    $("#span"+value).text("Sem Salas Disponíveis").css('color', 'red');
                    $("#link"+value).remove();
                });
                console.log(dados);
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

</script>
