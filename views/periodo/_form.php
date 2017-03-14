<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Periodo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'identificador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intervalo')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'turno')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'], ['prompt'=>'Selecione...']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
