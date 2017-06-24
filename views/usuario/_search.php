<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="input-group">
            <input type="nome" id="uauariosearch-nome" class="form-control" name="UsuarioSearch[nome]" value="" placeholder="Buscar usuário...">
            <span class="input-group-btn"><?= Html::submitButton("<i class='fa fa-search' aria-hidden='true'></i>", ['class' => 'btn btn-primary']) ?></span>
        </div>
    </div>

    <?= ''//$form->field($model, 'id') ?>

    <?= ''//$form->field($model, 'nome') ?>

    <?= ''//$form->field($model, 'email') ?>

    <?= ''//$form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <!--<div class="form-group">
        <?= ''//Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= ''//Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

</div>
