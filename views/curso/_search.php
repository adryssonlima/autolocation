<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CursoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curso-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= ''//$form->field($model, 'nome')->textInput()->input('nome', ['placeholder' => "Buscar..."])->label(false); ?>

    <div class="row">
        <div class="input-group">
            <input type="nome" id="cursosearch-nome" class="form-control" name="CursoSearch[nome]" value="" placeholder="Buscar curso...">
            <span class="input-group-btn"><?= Html::submitButton("<i class='fa fa-search' aria-hidden='true'></i>", ['class' => 'btn btn-primary']) ?></span>
        </div>
    </div>

    <!--<div class="form-group">
        <?= ''//Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
        <?= ''// Html::resetButton('Limpar', ['class' => 'btn btn-default']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

</div>
