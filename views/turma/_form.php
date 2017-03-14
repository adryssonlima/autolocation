<?php

use app\models\Curso;
use app\models\Turma;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Turma */
/* @var $form ActiveForm */
?>

<div class="turma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'identificador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'curso')->dropDownList(ArrayHelper::map(Curso::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione...']) ?>

    <?= $form->field($model, 'semestre')->dropDownList([], ['prompt'=>'Selecione...']) ?>

    <?= $form->field($model, 'turno')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'], ['prompt'=>'Selecione...']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    
    $('#turma-curso').on('change', function (e) {
        var id_disciplina = $(this).val();
        getSemestres(id_disciplina);
    });

    function getSemestres(value) {
            $.ajax({
                url: '<?= Yii::$app->request->baseUrl . '/?r=turma/get-quantidade-semestres' ?>',
                type: 'post',
                data: {
                    id: value
                },
                success: function (data) {
                    //console.log(data);
                    $("#turma-semestre").empty();
                    for (i = 1; i <= data; i++) { 
                        $("#turma-semestre").append($("<option></option>").attr("value", i).text(i));
                    }
                },
                error: function () {
                    console.log("Erro ao submeter requisição Ajax");
                }
            });
    }

</script>