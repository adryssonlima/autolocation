<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = 'Editar Turma: ' . $model->identificador;
//$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turma-update">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('create', [
        'model' => $model,
    ]) ?>

</div>

<script>
    
    $(document).ready(function(){
        getSemestres("<?= $model->curso ?>", "<?= $model->semestre ?>");

        $("#conf-dados-turma").prop("disabled",false);
        $("#valida").text("");
        
    });


</script>