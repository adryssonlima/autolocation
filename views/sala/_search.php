<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sala-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="input-group">
            <input type="identificador" id="salasearch-identificador" class="form-control" name="SalaSearch[identificador]" value="" placeholder="Buscar sala...">
            <span class="input-group-btn"><?= Html::submitButton("<i class='fa fa-search' aria-hidden='true'></i>", ['class' => 'btn btn-primary']) ?></span>
        </div>
    </div>

    <?= '' //$form->field($model, 'id') ?>

    <?= '' //$form->field($model, 'identificador') ?>

    <?= '' //$form->field($model, 'tipo') ?>

    <!--<div class="form-group">
        <?= '' //Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= '' //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

</div>
