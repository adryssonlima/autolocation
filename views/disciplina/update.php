<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disciplina */

$this->title = 'Update Disciplina: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disciplina-update">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>

    var url = '<?= Yii::$app->request->baseUrl . '/?r=disciplina/get-quantidade-semestres' ?>';
    var csrftoken = '<?= Yii::$app->request->getCsrfToken() ?>';

    $( document ).ready(function($) {
        var curso = $(' #disciplina-curso option:checked' ).val();
        getSemestres(url, curso, csrftoken);
        $("#disciplina-semestre_ref").val("<?= $model->semestre_ref ?>").change();
    });

    $('#disciplina-curso').on('change', function (e) {
        curso = $(this).val();
        getSemestres(url, curso, csrftoken);
    });

</script>
