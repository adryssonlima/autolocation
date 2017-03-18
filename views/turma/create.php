<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = 'Criar Turma';
//$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-create">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script>

    $('#conf-dados-turma').click(function() {
        var identificador = $('#turma-identificador').val();
        var curso = $('#turma-curso').val();
        var semestre = $('#turma-semestre').val();
        var turno = $('#turma-turno').val();
        createTurma(identificador, curso, semestre, turno);
    });

    function createTurma(identificador, curso, semestre, turno) {
            $.ajax({
                url: '<?= Yii::$app->request->baseUrl . '/?r=turma/nova-turma' ?>',
                type: 'post',
                data: {
                    id_identificador: identificador,
                    id_curso: curso,
                    id_semestre: semestre,
                    id_turno: turno
                },
                success: function (data) {
                    console.log(data);

                },
                error: function () {
                    console.log("Erro ao submeter requisição Ajax");
                }
            });
    }

</script>
