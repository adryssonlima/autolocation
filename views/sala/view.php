<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sala */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sala-view">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>
    $('.sala-view').find(':input').prop('disabled', true);
    $('.acoes').find(':input').prop('disabled', false);
    $('.aplicar').remove();
    $('.dismiss').html("<i class='fa fa-times' aria-hidden='true'></i> Fechar");
</script>