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

</script>
