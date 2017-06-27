<?php

use app\models\Curso;
use app\models\Disciplina;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Disciplina */
/* @var $form ActiveForm */
?>

<div class="disciplina-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'curso')->dropDownList(ArrayHelper::map(Curso::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione...']) ?>

    <?= $form->field($model, 'semestre_ref')->dropDownList([], ['prompt' => 'Selecione...']) ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'cht')->dropDownList(['0' => '0', '44' => '44', '88' => '88']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'chp')->dropDownList(['0' => '0', '44' => '44', '88' => '88']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'chc')->dropDownList(['0' => '0', '44' => '44', '88' => '88']) ?>
        </div>
    </div>
    <br>

    <div class="form-group pull-right acoes">
        <?= Html::button("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['class' => 'btn btn-default dismiss', "data-dismiss" => "modal"]) ?>
        <?= Html::submitButton($model->isNewRecord ? "<i class='fa fa-check' aria-hidden='true'></i> Criar" : "<i class='fa fa-check' aria-hidden='true'></i> Alterar", ['class' => $model->isNewRecord ? 'btn btn-success aplicar' : 'btn btn-primary aplicar']) ?>
        <input type="hidden" class="remover-bnt-confirmar" name="remover" value="false" />
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
    </div>
    <br><br>
    <?php ActiveForm::end(); ?>

</div>
