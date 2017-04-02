<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Curso */

$this->title = 'Delete Disciplina: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Delete';
?>
<div class="disciplina-delete">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>
    $('.disciplina-form').find(':input').prop('disabled', true);
    $('.acoes').find(':input').prop('disabled', false);
    $('.aplicar').addClass('btn btn-danger');
    $('.aplicar').html("<i class='fa fa-check' aria-hidden='true'></i> Remover");
    $('.remover-bnt-confirmar').val("true");

    var url = '<?= Yii::$app->request->baseUrl . '/?r=disciplina/get-quantidade-semestres' ?>';
    var csrftoken = '<?= Yii::$app->request->getCsrfToken() ?>';

    $( document ).ready(function($) {
        var curso = $(' #disciplina-curso option:checked' ).val();
        getSemestres(url, curso, csrftoken);
        $("#disciplina-semestre_ref").val("<?= $model->semestre_ref ?>");
    });
</script>
