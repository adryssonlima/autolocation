<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HorarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'turma') ?>

    <?= $form->field($model, 'disciplina') ?>

    <?= $form->field($model, 'semana') ?>

    <?= $form->field($model, 'sala') ?>

    <?php // echo $form->field($model, 'periodo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
