<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Curso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= ''//$form->field($model, 'qtd_semestre')->textInput(['type' => 'number', 'maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-3">
            <span value="1" class="label label-primary clicavel add-semestre" title="Clique para adicionar semestre"><i class="fa fa-plus-circle" aria-hidden="true"></i> Semestre</span>
            &nbsp;&nbsp;&nbsp;<span value="" class="label label-danger clicavel rm-semestre hidden" title="Clique para remover o último semestre adicionado"><i class="fa fa-minus-circle" aria-hidden="true"></i> Semestre</span>
        </div>
    </div>
    <br>
    <div class="semestres">

    </div>

    <br><br>
    <div class="form-group pull-right acoes">
        <?= Html::button("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['class' => 'btn btn-default', "data-dismiss" => "modal"]) ?>
        <?= Html::submitButton($model->isNewRecord ? "<i class='fa fa-check' aria-hidden='true'></i> Criar" : "<i class='fa fa-check' aria-hidden='true'></i> Alterar", ['class' => $model->isNewRecord ? 'btn btn-success aplicar' : 'btn btn-primary aplicar']) ?>
        <input type="hidden" class="remover-bnt-confirmar" name="remover" value="false" />
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
    </div>
    <br><br>
    <?php ActiveForm::end(); ?>

</div>

<script>

    function addDisciplina(semestre) {
        var disciplina = '<div class="row margin-bottom">'+
            '<div class="col-md-7">'+
                '<input type="text" class="form-control" name="disciplina" maxlength="100" aria-required="true">'+
            '</div>'+
            '<div class="col-md-1">'+
                '<select class="form-control padding" name="cht">'+
                    '<option value="0">0</option>'+
                    '<option value="44">44</option>'+
                    '<option value="88">88</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-md-1">'+
                '<select class="form-control padding" name="chp">'+
                    '<option value="0">0</option>'+
                    '<option value="44">44</option>'+
                    '<option value="88">88</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-md-1">'+
                '<select class="form-control padding" name="chc">'+
                    '<option value="0">0</option>'+
                    '<option value="44">44</option>'+
                    '<option value="88">88</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-md-2">'+
                '<span class="clicavel rm-disciplina" title="Remover Disciplina"><i class="fa fa-minus-circle fa-2x text-danger" aria-hidden="true"></i></span>'+
            '</div>'+
        '<br></div>';
        $('#disciplinas-semestre-'+semestre).append(disciplina);
    }

    function addSemestre(value) {
        var semestre = '<div class="semestre" id="semestre'+value+'">'+

                '<label>'+value+'ª semestre: &nbsp;<span style="float: right;" semestre="'+value+'" class="label label-success clicavel add-disciplina" title="Clique para adicionar uma disciplina neste semestre"><i class="fa fa-plus-circle" aria-hidden="true"></i> Disciplina</span></label>'+
                '<div class="row">'+
                    '<div class="col-md-7"><label>Nome Disciplina:</label></div>'+
                    '<div class="col-md-1"><label>CH/T:</label></div>'+
                    '<div class="col-md-1"><label>CH/P:</label></div>'+
                    '<div class="col-md-1"><label>CH/C:</label></div>'+
                '</div>'+
                '<div class="disciplinas" id="disciplinas-semestre-'+value+'">'+
                    '<div class="row margin-bottom">'+
                        '<div class="col-md-7">'+
                            '<input type="text" class="form-control" name="disciplina" maxlength="100" aria-required="true">'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<select class="form-control padding" name="cht">'+
                                '<option value="0">0</option>'+
                                '<option value="44">44</option>'+
                                '<option value="88">88</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<select class="form-control padding" name="chp">'+
                                '<option value="0">0</option>'+
                                '<option value="44">44</option>'+
                                '<option value="88">88</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<select class="form-control padding" name="chc">'+
                                '<option value="0">0</option>'+
                                '<option value="44">44</option>'+
                                '<option value="88">88</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-2">'+
                            '<span class="clicavel rm-disciplina" title="Remover Disciplina"><i class="fa fa-minus-circle fa-2x text-danger" aria-hidden="true"></i></span>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

        '<br></div>';
        $('.semestres').append(semestre);
    }

    $(".add-semestre").click(function(){
        var value = $(this).attr('value');
        addSemestre(value);
        $(".rm-semestre").attr('value', value).removeClass('hidden');
        value++;
        $(this).attr('value', value);
    });

    $(".rm-semestre").click(function() {
        var value = $(this).attr('value');
        $('#semestre'+value).remove();
        $(".add-semestre").attr('value', value);
        value--;
        if (value == 0) {
            $(this).addClass('hidden');
        }
        $(this).attr('value', value);
    });

    $(".semestres").on("click", ".add-disciplina", function() {
        console.log("add Disciplina");
        var semestre = $(this).attr('semestre');
        addDisciplina(semestre);
    });

    $(".semestres").on("click", ".rm-disciplina", function() {
        console.log("rm Disciplina");
        $(this).closest('.row').remove();
    });

</script>

<style>
    .padding {
        padding: 1px;
    }
	.margin-bottom {
		margin-bottom: 7px;
	}
</style>
