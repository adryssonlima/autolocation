<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Curso;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];

?>

<div class="turma-delete">

    <h2><i class='fa fa-trash' aria-hidden='true'></i> Remover Turma</h2>
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

    <div class="form-group pull-right acoes">
        <?= Html::a("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['index'], ['class' => 'btn btn-default']) ?>&nbsp
        <?= Html::button("<i class='fa fa-check' aria-hidden='true'></i> Remover", ['class' => 'btn btn-danger delete']) ?>
    </div>
    <br><br>

</div>

<?php
Modal::begin([
    "header" => "<h3 class='modal-titulo'><i class='fa fa-trash-o aria-hidden='true'></i> Excluir Disciplina?</h3>",
    "id" => "modal"
]);
?>
<div class='modal-conteudo center aviso' style='margin-top: 0px;'>
    <p>
        <i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i>
        <br>
        Atenção, você tem certeza do que está fazendo? Todo o horário desta turma será removido permanentemente.
    </p>
</div>
<div class="form-group pull-right acoes">
    <?php $form = ActiveForm::begin(); ?>
        <?= Html::button("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['class' => 'btn btn-default dismiss', "data-dismiss" => "modal"]) ?>&nbsp
        <?= Html::submitButton("<i class='fa fa-check' aria-hidden='true'></i> Remover", ['class' => 'btn btn-danger aplicar']) ?>
        <input type="hidden" class="remover-bnt-confirmar" name="remover" value="true" />
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
    <?php ActiveForm::end(); ?>
</div>
<br><br>
<?php Modal::end(); ?>

<style>
    .center {
        text-align: center;
        margin-top: 30px;
    }
    .aviso {
        color: #999999;
        font-weight: bold;
    }
</style>

<script>

    $(document).ready(function() {
        let turno = '<?= $model[0]['turno'] ?>';
        createTabelaHorario(turno.charAt(0));
    });

    $(".delete").on('click', function(){
        $("#modal").modal('show');
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