<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplinaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disciplina-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="input-group">
            <input type="nome" id="disciplinasearch-nome" class="form-control" name="DisciplinaSearch[nome]" value="" placeholder="Buscar disciplina...">
            <span class="input-group-btn"><?= Html::submitButton("<i class='fa fa-search' aria-hidden='true'></i>", ['class' => 'btn btn-primary']) ?></span>
        </div>
    </div>

    <?= ''//$form->field($model, 'id') ?>

    <?= ''//$form->field($model, 'nome') ?>

    <?= ''//$form->field($model, 'curso') ?>

    <!--<div class="form-group">
        <?= ''//Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= ''//Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

</div>
