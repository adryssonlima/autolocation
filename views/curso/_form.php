<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Curso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="pull-right">
            <label>Ações</label><br>
            <button type="button" value="1" class="btn btn-primary add-semestre" title="Clique para adicionar semestre"><i class="fa fa-plus-circle" aria-hidden="true"></i> Semestre</button>
            <button type="button" value="" class="btn btn-danger rm-semestre hidden" title="Clique para remover o último semestre adicionado"><i class="fa fa-minus-circle" aria-hidden="true"></i> Semestre</button>
        </div>
    </div>

    <div class="center aviso info">
      <p>
          <i class="fa fa-info-circle fa-3x" aria-hidden="true"></i><br>
          Em Ações, adicione ou remova semestres e disicplinas ao curso
      </p>
    </div>

    <?= ''//$form->field($model, 'qtd_semestre')->textInput(['type' => 'number', 'maxlength' => true]) ?>

    <br>
    <div class="semestres">
        <div id="semestres-excluidos"></div>
        <div id="disciplinas-excluidas"></div>
    </div>

    <br><br>
    <div class="row">
        <div class="form-group pull-right acoes">
            <?= ''//Html::button("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['class' => 'btn btn-default', "data-dismiss" => "modal"]) ?>
            <?= Html::submitButton($model->isNewRecord ? "<i class='fa fa-check' aria-hidden='true'></i> Criar" : "<i class='fa fa-check' aria-hidden='true'></i> Alterar", ['class' => $model->isNewRecord ? 'btn btn-success aplicar' : 'btn btn-primary aplicar']) ?>
            <input type="hidden" class="remover-bnt-confirmar" name="remover" value="false" />
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
        </div>
    </div>
    <br><br>
    <?php ActiveForm::end(); ?>

</div>

<?php
Modal::begin([
    "header" => "<h3 class='modal-titulo'></h3>",
    "id" => "modal",
    "size" => "modal-sm",
]);
echo "<div class='modal-conteudo center aviso' style='margin-top: 0px;'>";
echo "<p><i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i><br>";
echo "O semestre e todas as disciplinas a ele relacionadas serão removidos.</p>";
echo "</div><br>";
echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>";
echo "&nbsp;<button type='button' class='btn btn-danger pull-right rm-semestre-confirm' data-dismiss='modal'><i class='fa fa-minus-circle' aria-hidden='true'></i> Remover</button>";
Modal::end();
?>

<script>

    function addDisciplina(idSemestre, idDisciplina) {
        var disciplina = '<div class="row margin-bottom" disciplina="'+idDisciplina+'">'+
            '<input type="hidden" name="Curso[semestres]['+idSemestre+'][disciplinas]['+idDisciplina+'][id]" />'+
            '<div class="col-md-8">'+
                '<input type="text" class="form-control" name="Curso[semestres]['+idSemestre+'][disciplinas]['+idDisciplina+'][nome]" maxlength="100" aria-required="true" required>'+
            '</div>'+
            '<div class="col-md-1">'+
                '<select class="form-control padding" name="Curso[semestres]['+idSemestre+'][disciplinas]['+idDisciplina+'][cht]">'+
                    '<option value="0">0</option>'+
                    '<option value="44">44</option>'+
                    '<option value="88">88</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-md-1">'+
                '<select class="form-control padding" name="Curso[semestres]['+idSemestre+'][disciplinas]['+idDisciplina+'][chp]">'+
                    '<option value="0">0</option>'+
                    '<option value="44">44</option>'+
                    '<option value="88">88</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-md-1">'+
                '<select class="form-control padding" name="Curso[semestres]['+idSemestre+'][disciplinas]['+idDisciplina+'][chc]">'+
                    '<option value="0">0</option>'+
                    '<option value="44">44</option>'+
                    '<option value="88">88</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-md-1">'+
                '<span semestre="'+idSemestre+'" disciplina="'+idDisciplina+'" class="pull-right clicavel rm-disciplina" title="Remover Disciplina"><i class="fa fa-minus-circle fa-2x text-danger" aria-hidden="true"></i></span>'+
            '</div>'+
        '<br></div>';
        $('#disciplinas-semestre-'+idSemestre).append(disciplina);
    }

    function addSemestre(value) {
        var semestre = '<div class="semestre" id="semestre'+value+'">'+
                '<input type="hidden" name="Curso[semestres]['+value+']" />'+
                '<label>'+value+'ª semestre: &nbsp;<span semestre="'+value+'" disciplina="2" class="label label-success clicavel add-disciplina" title="Clique para adicionar uma disciplina neste semestre"><i class="fa fa-plus-circle" aria-hidden="true"></i> Disciplina</span></label>'+
                '<div class="row">'+
                    '<div class="col-md-8"><label>Nome Disciplina:</label></div>'+
                    '<div class="col-md-1"><label>CH/T:</label></div>'+
                    '<div class="col-md-1"><label>CH/P:</label></div>'+
                    '<div class="col-md-1"><label>CH/C:</label></div>'+
                '</div>'+
                '<div class="disciplinas" id="disciplinas-semestre-'+value+'">'+

                '</div>'+
        '<br></div>';
        $('.semestres').append(semestre);
        addDisciplina(value, 1);
    }

    $(".add-semestre").click(function(){
        if(!$('.info').hasClass('hidden')){
            $('.info').addClass('hidden');
        }
        var value = $(this).attr('value');
        addSemestre(value);
        $(".rm-semestre").attr('value', value).removeClass('hidden');
        value++;
        $(this).attr('value', value);
    });

    $(".rm-semestre").click(function() {
        var value = $(this).attr('value');
        removeSemestre(value);
    });

    $(".rm-semestre-confirm").click(function() {
        var value = $(this).attr('value');
        var disciplinas_removidas = $('#disciplinas-semestre-'+value).find(':hidden').serializeArray();
        $.each(disciplinas_removidas, function(index, value) { //Adiciona as disciplinas desse semestre na tag de excluídas
            $("#disciplinas-excluidas").append('<input type="hidden" name="Curso[removidas][]" value="'+value['value']+'" />');
        });
        $('#semestre'+value).remove();
        $(".add-semestre").attr('value', value);
        value--;
        if (value == 0) {
            $('.rm-semestre').addClass('hidden');
            $('.info').removeClass('hidden');
        }
        $('.rm-semestre').attr('value', value);
    });

    $(".semestres").on("click", ".add-disciplina", function() {
        var idSemestre = $(this).attr('semestre');
        var idDisciplina = $(this).attr('disciplina');
        addDisciplina(idSemestre, idDisciplina);
        idDisciplina++;
        $(this).attr('disciplina', idDisciplina);
    });

    $(".semestres").on("click", ".rm-disciplina", function() {
        var semestre = $(this).attr('semestre');
        var disciplina = $(this).attr('disciplina');
        var idDisciplina = $(this).closest('.row').find('input[name="Curso[semestres]['+semestre+'][disciplinas]['+disciplina+'][id]"]').val();
        $("#disciplinas-excluidas").append('<input type="hidden" name="Curso[removidas][]" value="'+idDisciplina+'" />');
        $(this).closest('.row').remove();
    });

    function removeSemestre(value) {
        //verifica se no ultimo semestre existem disciplinas que não podem ser removidas
        var disciplinasNotRemove = $("#disciplinas-semestre-"+value).find('.remove-disable').attr('class');
        if (typeof disciplinasNotRemove != "undefined") {
            $(".modal-titulo").html('Não é possível remover o ' + value + 'ª Semestre!');
            $(".modal-conteudo").html("<p><i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i><br>Existe uma ou mais turmas cursando alguma disciplina desse semestre.</p>");
            $(".rm-semestre-confirm").prop('disabled', true);
            $("#modal").modal("show");
        } else {
            $(".modal-titulo").html('Remover ' + value + 'ª Semestre?');
            $(".rm-semestre-confirm").val(value);
            $("#modal").modal("show");
        }
    }

</script>

<style>
    .padding {
        padding: 1px;
    }
	.margin-bottom {
		margin-bottom: 7px;
	}
    .center {
        text-align: center;
        margin-top: 30px;
    }
    .aviso {
        color: #999999;
        font-weight: bold;
    }
</style>
