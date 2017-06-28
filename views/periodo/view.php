<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Periodo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Periodos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodo-view">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>
    $('.periodo-view').find(':input').prop('disabled', true);
    $('.acoes').find(':input').prop('disabled', false);
    $('.aplicar').remove();
    $('.dismiss').html("<i class='fa fa-times' aria-hidden='true'></i> Fechar");
</script>