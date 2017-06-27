<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Disciplina */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="disciplina-view">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>
    $('.disciplina-form').find(':input').prop('disabled', true);
    $('.acoes').find(':input').prop('disabled', false);
    $('.aplicar').remove();
    $('.dismiss').html("<i class='fa fa-times' aria-hidden='true'></i> Fechar");
    $('.remover-bnt-confirmar').val("true");

    var url = '<?= Yii::$app->request->baseUrl . '/disciplina/get-quantidade-semestres' ?>';
    var csrftoken = '<?= Yii::$app->request->getCsrfToken() ?>';

    $( document ).ready(function($) {
        var curso = $(' #disciplina-curso option:checked' ).val();
        var semestreDisciplina = "<?= $model->semestre_ref ?>";
        getSemestres(url, curso, semestreDisciplina, csrftoken);
    });
</script>
