<?php

use app\models\Disciplina;
use app\models\Horario;
use app\models\Periodo;
use app\models\Sala;
use app\models\Semana;
use app\models\Turma;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Horario */
/* @var $form ActiveForm */

$turmas = ArrayHelper::map(Turma::find()->all(), 'id', 'identificador');
$disciplinas = ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome');
$semanas = ArrayHelper::map(Semana::find()->all(), 'id', 'dia');
$salas = ArrayHelper::map(Sala::find()->all(), 'id', 'identificador');
$periodos = ArrayHelper::map(Periodo::find()->all(), 'id', 'identificador');

?>

<div class="horario-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group field-turma required">
        <label class="control-label" for="turma">Turma</label>
        <select id="turma" class="form-control" name="turma" aria-required="true" aria-invalid="true">
            <option value="">Selecione...</option>
            <?php foreach ($turmas as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group field-disciplina required">
        <label class="control-label" for="disciplina">Disciplina</label>
        <select id="disciplina" class="form-control" name="disciplina" aria-required="true" aria-invalid="true">
            <option value="">Selecione...</option>
            <?php foreach ($disciplinas as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group field-semana required">
        <label class="control-label" for="semana">Dia da Semana</label>
        <select id="semana" class="form-control" name="semana" aria-required="true" aria-invalid="true">
            <option value="">Selecione...</option>
            <?php foreach ($semanas as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group field-sala required">
        <label class="control-label" for="sala">Sala</label>
        <select id="sala" class="form-control" name="sala" aria-required="true" aria-invalid="true">
            <option value="">Selecione...</option>
            <?php foreach ($salas as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group field-periodo required">
        <label class="control-label" for="periodo">Horário</label>
        <select id="periodo" class="form-control" name="periodo" aria-required="true" aria-invalid="true">
            <option value="">Selecione...</option>
            <?php foreach ($periodos as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </div>
    
    <?=''// $form->field($model, 'turma')->dropDownList(ArrayHelper::map(Turma::find()->all(), 'id', 'identificador'), ['prompt' => 'Selecione...']) ?>

    <?=''// $form->field($model, 'disciplina')->dropDownList(ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione...']) ?>

    <?=''// $form->field($model, 'semana')->dropDownList(ArrayHelper::map(Semana::find()->all(), 'id', 'dia'), ['prompt' => 'Selecione...']) ?>

    <?=''// $form->field($model, 'sala')->dropDownList(ArrayHelper::map(Sala::find()->all(), 'id', 'identificador'), ['prompt' => 'Selecione...']) ?>

    <?=''// $form->field($model, 'periodo')->dropDownList(ArrayHelper::map(Periodo::find()->all(), 'id', 'identificador'), ['prompt' => 'Selecione...']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
    
    $('#turma').on('change', function (e) {
        var id_turma = $(this).val();
        getOptions(id_turma, 'get-disciplinas-turma', 'disciplina');
    });
    
    $('#disciplina').on('change', function (e) {
       // var id_disciplina = $(this).val();
        getOptions(null, 'get-dias-da-semana-livres', 'semana');
    });

    function getOptions(id, method, id_select) {
            $.ajax({
                url: '<?= Yii::$app->request->baseUrl . '/?r=horario/' ?>' + method,
                type: 'post',
                data: {
                    id: id
                },
                success: function (data) {
                    console.log(data);
                    var array = $.parseJSON(data);
                    $("#"+id_select).empty();
                    $.each(array, function(index, value) {
                        $("#"+id_select).append($("<option></option>").attr("value", index).text(value));
                    });
                },
                error: function () {
                    console.log("Erro ao submeter requisição Ajax");
                }
            });
    }

</script>