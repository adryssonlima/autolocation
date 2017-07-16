<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Curso;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = 'Delete Turma: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Delete';
?>

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

<div class="turma-delete">

    <?php $form = ActiveForm::begin(); ?>

    <div class='modal-conteudo center aviso' style='margin-top: 0px;'>
        <p>
            <i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i>
            <br>
            Atenção, você tem certeza do que está fazendo? Todo o horário desta turma será removido permanentemente.
        </p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'identificador')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'curso')->dropDownList(ArrayHelper::map(Curso::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione...']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'semestre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'turno')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'], ['prompt'=>'Selecione...']) ?>
        </div>
    </div>

    <div class="form-group pull-right acoes">
        <?= Html::button("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['class' => 'btn btn-default dismiss', "data-dismiss" => "modal"]) ?>
        <?= Html::submitButton("<i class='fa fa-check' aria-hidden='true'></i> Remover", ['class' => 'btn btn-danger aplicar']) ?>
        <input type="hidden" class="remover-bnt-confirmar" name="remover" value="false" />
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
    </div>
    <br><br>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $('.turma-delete').find(':input').prop('disabled', true);
    $('.acoes').find(':input').prop('disabled', false);
    $('.remover-bnt-confirmar').val("true");
</script>
