<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Curso */

$this->title = 'Criar Curso';
//$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-create">

    <h1><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
