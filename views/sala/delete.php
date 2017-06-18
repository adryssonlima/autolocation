<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sala */

$this->title = 'Delete Sala: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sala', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Sala';
?>
<div class="sala-delete">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>
    $('.sala-form').find(':input').prop('disabled', true);
    $('.acoes').find(':input').prop('disabled', false);
    $('.aplicar').addClass('btn btn-danger');
    $('.aplicar').html("<i class='fa fa-check' aria-hidden='true'></i> Remover");
    $('.remover-bnt-confirmar').val("true");
</script>
