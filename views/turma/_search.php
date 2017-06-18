<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TurmaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turma-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="input-group">
            <input type="identificador" id="turmasearch-identificador" class="form-control" name="TurmaSearch[identificador]" value="" placeholder="Buscar turma...">
            <span class="input-group-btn"><?= Html::submitButton("<i class='fa fa-search' aria-hidden='true'></i>", ['class' => 'btn btn-primary']) ?></span>
        </div>
    </div>

    <?= '' //$form->field($model, 'id') ?>

    <?= '' //$form->field($model, 'identificador') ?>

    <?= '' //$form->field($model, 'curso') ?>

    <?= '' //$form->field($model, 'semestre') ?>

    <?= '' //$form->field($model, 'turno') ?>

    <!--<div class="form-group">
        <?= '' //Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= '' //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

</div>
