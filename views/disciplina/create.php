<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Disciplina */

$this->title = 'Create Disciplina';
$this->params['breadcrumbs'][] = ['label' => 'Disciplinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-create">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>

    var url = '<?= Yii::$app->request->baseUrl . '/disciplina/get-quantidade-semestres' ?>';
    var csrftoken = '<?= Yii::$app->request->getCsrfToken() ?>';

    $('#disciplina-curso').on('change', function (e) {
        curso = $(this).val();
        getSemestres(url, curso, csrftoken);
    });

</script
