<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Curso */

$this->title = 'Editando o Curso: ' . '<span class="aviso">' . $curso->nome . '</span>';
//$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="curso-update">

    <h1><i class='fa fa-pencil-square-o' aria-hidden='true'></i> <?= $this->title ?></h1>
    <br>
    <?= $this->render('_form', [
        'model' => $curso,
    ]) ?>


</div>

<script>

    var qtd_semestre = '<?= $curso->qtd_semestre ?>';
    var disciplinas = $.parseJSON('<?= $disciplinas ?>');

    $(document).ready(function(){
        //console.log(disciplinas);
        if (qtd_semestre) {
            $(".rm-semestre").removeClass('hidden');
            $('.info').addClass('hidden');
        } else {
            $('.info').removeClass('hidden');
        }

        for (var idSemestre=1; idSemestre<=qtd_semestre; idSemestre++) {
            addSemestre(idSemestre);
            $("#disciplinas-semestre-"+idSemestre).find("div[disciplina='1']").remove();
            var idDisciplina = 0;
            $.each(disciplinas, function(index, value) {
                if(value['semestre_ref'] == idSemestre) {
                    idDisciplina++;
                    addDisciplina(idSemestre, idDisciplina);
                    $("input[name='Curso[semestres]["+idSemestre+"][disciplinas]["+idDisciplina+"][id]']").val(value['id']);
                    $("input[name='Curso[semestres]["+idSemestre+"][disciplinas]["+idDisciplina+"][nome]']").val(value['nome']);
                    $("select[name='Curso[semestres]["+idSemestre+"][disciplinas]["+idDisciplina+"][cht]']").val(value['cht']);
                    $("select[name='Curso[semestres]["+idSemestre+"][disciplinas]["+idDisciplina+"][chp]']").val(value['chp']);
                    $("select[name='Curso[semestres]["+idSemestre+"][disciplinas]["+idDisciplina+"][chc]']").val(value['chc']);
                    if (value['horario']) { //faz o tratamento caso a disciplina esteja referenciada a uma turma
                        $("#disciplinas-semestre-"+idSemestre).find("div[disciplina='"+idDisciplina+"']").find(':input').prop('disabled', true);
                        $("#disciplinas-semestre-"+idSemestre).find("div[disciplina='"+idDisciplina+"']").find('span').removeClass('clicavel rm-disciplina').attr('title', 'Existe uma ou mais turmas cursando essa disciplina').find('i').removeClass('fa-minus-circle').addClass('fa-exclamation-triangle remove-disable');
                    }
                }
            });
            //seta o valor do botao add-disciplina
            $("#semestre"+idSemestre).find(".add-disciplina").attr('disciplina', idDisciplina+1);
        }
        //seta os valores dos botões
        $(".add-semestre").val(parseInt(qtd_semestre)+1);
        $(".rm-semestre").val(qtd_semestre);
        $(".rm-semestre-confirm").val(qtd_semestre);
    });

</script>
