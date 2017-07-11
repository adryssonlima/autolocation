<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */
$this->title = 'Editar Turma: ' . $model->identificador;
//$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turma-update">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php
Modal::begin([
    "header" => "<h3 class='modal-titulo'>Atenção!</h3>",
    "id" => "modal-aviso",
    "size" => "modal-sm",
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false
]);
echo "<div class='modal-conteudo center aviso' style='margin-top: 0px;'>";
echo "<p><i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i><br>";
echo "Ao alterar o semestre, todo o horário atual da turma será perdido.</p>";
echo "<p>Tem certeza que deseja fazer isso?</p>";
echo "</div><br>";
echo "<button type='button' class='btn btn-default cancel-alter-semestre' data-dismiss='modal'>Cancelar</button>";
echo "&nbsp;<button type='button' class='btn btn-danger pull-right confirm-alter-semestre' data-dismiss='modal'><i class='fa fa-check' aria-hidden='true'></i> Tenho certeza</button>";
Modal::end();
?>

<?php
Modal::begin([
    "header" => "<h3 class='modal-titulo'>Atenção!</h3>",
    "id" => "modal-choque",
    "size" => "modal-sm",
]);
echo "<div class='modal-conteudo center aviso' style='margin-top: 0px;'>";
echo "<p><i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i><br>";
echo "As disciplinas em vermelho estão com choque de horários.</p>";
echo "<p>Clique em 'Voltar' para fazer a correção.</p>";
echo "</div><br>";
echo "<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>Ok</button><br><br>";
Modal::end();
?>

<style>
    .padding {
        padding: 1px;
    }
	.margin-bottom {
		margin-bottom: 7px;
	}
    .center {
        text-align: center;
        margin-top: 30px;
    }
    .aviso {
        color: #999999;
        font-weight: bold;
    }
</style>

<script>
    
    $(document).ready(function(){

        $("#turma-curso").prop("disabled", true);
        $("#turma-turno").prop("disabled", true);

        getSemestres("<?= $model->curso ?>", "<?= $model->semestre ?>");

        $("#conf-dados-turma").prop("disabled",false);
        $("#valida").text("");

        var turno = $('#turma-turno').val();
        createTabelaHorario(turno);

    });

</script>

<script>

    $("#turma-semestre").change(function() { //verifica a alteração de semestre
        $("#modal-aviso").modal("show");
        $(".cancel-alter-semestre").click(function(){
            $("#turma-semestre").val("<?= $model->semestre ?>");
        });
        $(".confirm-alter-semestre").click(function(){
            $("#tbody-periodos").find(".info-turma").remove();
            $("#tbody-periodos").find(".info-turma-disciplina-sala").text("");
        });
    });

    $("#table-horario").on( "click", "a", function() {
        var dia = $(this).attr("id_dia");
        var periodo = $(this).attr("id_periodo");
        if ($(this).find("span").attr("class") == "glyphicon glyphicon-trash") {
            $("#hidden"+dia+periodo).remove();
            //$("#span"+dia+periodo).hide('1000');
            $("#span"+dia+periodo).text("");
            $(this).remove();
        } else {
            var curso = $("#turma-curso").val();
            var semestre = $("#turma-semestre").val();
            $("#dia-periodo").attr("dia", dia); //guarda o valor no campo hidden do modal
            $("#dia-periodo").attr("periodo", periodo); //guarda o valor no campo hidden do modal
            getSalasDisciplinas(dia, periodo, curso, semestre);
        }
    });

    $(".modal-confirmar").click(function(){
        var dia = $("#dia-periodo").attr("dia");
        var periodo = $("#dia-periodo").attr("periodo");
        var sala = $("#modal-sala option:selected").val();
        var disciplina = $("#modal-disciplina option:selected").val();
        if ($("#hidden"+dia+periodo).length) {
            //edita hidden com as informações do horário caso exista
            $("#hidden"+dia+periodo).attr('dia', dia);
            $("#hidden"+dia+periodo).attr('periodo' ,periodo);
            $("#hidden"+dia+periodo).attr('sala', sala);
            $("#hidden"+dia+periodo).attr('disciplina', disciplina);
        } else {
            //adiciona hidden com as informações do horário caso ainda não exista
            $("#td"+dia+periodo).append("<hidden class='info-turma' id='hidden" + dia+periodo + "' dia='" + dia + "' periodo='" + periodo + "' sala='" + sala + "' disciplina='" + disciplina + "' />");
        }
        
        var sala = $("#modal-sala option:selected").text();
        var disciplina = $("#modal-disciplina option:selected").text();
        $("#span"+dia+periodo).text("");
        $("#span"+dia+periodo).append(disciplina + "<br>" + sala);
        $("#td"+dia+periodo).css('text-align','center');
        $("#span"+dia+periodo).css( "color", "black" );
        if (!$("#linkremove" + dia+periodo).length) {
            $("#td"+dia+periodo).append("<a id='linkremove" + dia+periodo + "' id_dia='" + dia + "' id_periodo='" + periodo + "' href='#/' class='pull-right text-danger' style='margin-right: 2px;' title='Remover'> <span class='glyphicon glyphicon-trash'></span> </a>");
        }
    });

    $( "#conf-horario" ).click(function(){ // resumo dos dados
        $("#span-identificador").text($("#turma-identificador").val());
        $("#span-curso").text($("#turma-curso option:selected").text());
        $("#span-semestre").text($("#turma-semestre option:selected").text());
        $("#span-turno").text($("#turma-turno option:selected").text());
        $("#div-table-horario-confirmar").append($("#table-horario")); //move a table horario para o wizard de confirmar dados
        $("#table-horario").find("a").addClass("hidden"); //esconde os links de ação
        $("#table-horario td").each(function() { //percorre todos os tds ta table
            if (!$(this).find("a").length) { //se não existir link de ação no td, aplica hidden na span
                $(this).find("span").addClass("hidden");
            }
        });
    });

    $( "#btn-conf-voltar" ).click(function(){ //move a table horario para o wizard de definir horario
        $("#div-table-horario").append($("#table-horario"));
        $("#table-horario").find("a").removeClass("hidden"); //mostra os links de ação
        $("#table-horario td").each(function() { //percorre todos os tds ta table
            if (!$(this).find("a").length) { //se não existir link de ação no td, remove hidden da span
                $(this).find("span").removeClass("hidden");
            }
        });
    });

    $("#btn-finalizar").click(function(){
        var identificador = $('#turma-identificador').val();
        var curso = $('#turma-curso').val();
        var semestre = $('#turma-semestre').val();
        var turno = $('#turma-turno').val();

        verificacaoFinal(identificador, curso, semestre, turno);
    });

    function verificacaoFinal(identificador, curso, semestre, turno) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/horarios-ocupados' ?>',
            type: 'post',
            data: {
                id: null
            },
            success: function (data) {
                let ocupados = $.parseJSON(data);
                //console.log(ocupados);

                let horario = $.parseJSON('<?= $horario ?>');
                horario.forEach(function(val) { //remove dos horarios ocupados os horarios da turma a ser editada
                    let = semana_periodo = val.semana+val.periodo;
                    $.each(ocupados, function(i, v) {
                        if (semana_periodo == v)
                            delete ocupados[i];
                    });
                });
                //console.log(ocupados);

                let arrayhorarios = [];
                $("#table-horario td hidden").each(function() {
                    let horario = { //os atributos devem estar OBRIGATORIAMENTE nessa ordem!!!
                        turma: null, //atributo usado para guardar o id da turma apos inserida no banco
                        dia: $(this).attr("dia"),
                        sala: $(this).attr("sala"),
                        periodo: $(this).attr("periodo"),
                        disciplina: $(this).attr("disciplina")
                    };
                    arrayhorarios.push(horario);
                });
                //console.log(arrayhorarios);
                
                //VERIFICA SE EXISTEM HORARIOS COM CHOQUE
                let arrayHorariosChoque = [];
                arrayhorarios.forEach(function(val) {
                    let = dia_periodo = val.dia+val.periodo;
                    $.each(ocupados, function(i, v) {
                        if (dia_periodo == v) {
                            arrayHorariosChoque.push(i);
                        }
                    });
                });

                if (!arrayHorariosChoque.length) {
                    //console.log('pode salvar');
                    updateTurmaHorario(identificador, curso, semestre, turno, arrayhorarios);
                } else {
                    //console.log('horarios com choque');
                    arrayHorariosChoque.forEach(function(i, v){
                        $("#span"+v).css( "color", "red" );
                    });
                    $("#modal-choque").modal("show");
                }
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function createTabelaHorario(turno) { //Cria a tabela de horáarios dinamicamente com base no turno da turma
        return $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/get-dias-periodos' ?>',
            type: 'post',
            data: {
                turno: turno
            },
            success: function (data) {
                var dados = $.parseJSON(data);
                var dias_da_semana = dados['dias'];
                var periodos = dados['periodos'];
                                
                if (montaTabelaHorario(dias_da_semana, periodos)) {
                    getHorariosOcupados();
                }
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function montaTabelaHorario(dias_da_semana, periodos) {
        $("#th-dias-da-semana").empty();
        $('#th-dias-da-semana').append("<th class='th-center'><span class='glyphicon glyphicon-time'></span></th>");
        $.each(dias_da_semana, function(keyDia, dia) {
            $('#th-dias-da-semana').append("<th class='th-center'>" + dia['dia'] + "</th>");
        });
        $("#tbody-periodos").empty();
        $.each(periodos, function(keyPeriodo, periodo) {
            $('#tbody-periodos').append("<tr id='" + periodo['id'] + "'><th class='th-center'>" + periodo['identificador'] + "<br>" + periodo['intervalo'] + "</th></tr>");
            $.each(dias_da_semana, function(keyDia, dia) {
                $('#'+periodo['id']).append("<td id='td" + dia['id']+periodo['id'] + "' class='tdhover'> <span class='info-turma-disciplina-sala' id='span" + dia['id']+periodo['id'] + "'></span> <a id='link" + dia['id']+periodo['id'] + "' id_dia='" + dia['id'] + "' id_periodo='" + periodo['id'] + "' href='#' class='pull-right text-success' data-toggle='modal' data-target='#myModal' title='Editar'> <span class='glyphicon glyphicon-pencil'></span> </a> </td>");
            });
        });
        return true;
    }

    //setInterval(getHorariosOcupados,2000);

    function getHorariosOcupados() {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/horarios-ocupados' ?>',
            type: 'post',
            data: {
                id: null
            },
            success: function (data) {
                var ocupados = $.parseJSON(data);
                //console.log(ocupados);
                var horario = $.parseJSON('<?= $horario ?>');
                //console.log(horario);
                if (setTableHorariosCocupados(ocupados, horario)) {
                    preencheTabelaHorario(horario);
                }
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function preencheTabelaHorario(horario) { //Pega os dados de horários da turma e preenche a tabela
        horario.forEach(function(val) {
            //console.log(val);
            $("#td"+val.semana+val.periodo).find("#span"+val.semana+val.periodo).html(val.nome_disciplina+"<br>"+val.identificador_sala);
            $("#td"+val.semana+val.periodo).css('text-align','center');                        
            $("#td"+val.semana+val.periodo).append("<hidden class='info-turma' id='hidden"+val.semana+val.periodo+"' dia='"+val.semana+"' periodo='"+val.periodo+"' sala='"+val.sala+"' disciplina='"+val.disciplina+"'></hidden>");
            $("#td"+val.semana+val.periodo).append("<a id='linkremove"+val.semana+val.periodo+"' id_dia='"+val.semana+"' id_periodo='"+val.periodo+"' href='#' class='pull-right text-danger info-turma' style='margin-right: 2px;' title='Remover'> <span class='glyphicon glyphicon-trash'></span> </a>");
        });
        return true;
    }

    function setTableHorariosCocupados(ocupados, horario) {

        horario.forEach(function(val) { //remove dos horarios ocupados os horarios da turma a ser editada
            let = semana_periodo = val.semana+val.periodo;
            $.each(ocupados, function(i, v) {
                if (semana_periodo == v)
                    delete ocupados[i];
            });
        });

        $("#table-horario").find("span").text("");
        $.each(ocupados, function(index, value) {
            $("#span"+value).removeClass("info-turma-disciplina-sala");
            $("#span"+value).text("Sem Salas Disponíveis").css('color', 'red');
            $("#td"+value).css('text-align','center');
            $("#link"+value).remove();
        });
        return true;
    }

    function getSalasDisciplinas(dia, periodo, curso, semestre) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/get-salas-disciplinas' ?>',
            type: 'post',
            data: {
                id_dia: dia,
                id_periodo: periodo,
                id_curso: curso,
                semestre: semestre
            },
            success: function (data) {
                var dados = $.parseJSON(data);
                var salas = dados['salas'];
                var disciplinas = dados['disciplinas'];
                $("#modal-sala").empty();
                $.each(salas, function(index, value) {
                    $("#modal-sala").append($("<option></option>").attr("value", index).text(value));
                });
                $("#modal-disciplina").empty();
                $.each(disciplinas, function(index, value) {
                    $("#modal-disciplina").append($("<option></option>").attr("value", index).text(value));
                });

                var horario = $.parseJSON('<?= $horario ?>');
                horario.forEach(function(val){
                    if (val.semana == dia && val.periodo == periodo) {
                        $("#modal-sala").append($("<option></option>").attr("value", val.sala).text(val.identificador_sala));
                        $("#modal-sala").val(val.sala);
                        if ($("#modal-disciplina option[value='"+val.disciplina+"']").val()) {
                            $("#modal-disciplina").val(val.disciplina);
                        }
                    }
                });
                //console.log(dados);
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function updateTurmaHorario(identificador, curso, semestre, turno, arrayhorarios) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/update-turma' ?>',
            type: 'post',
            data: {
                id: "<?= $model->id ?>",
                identificador: identificador,
                curso: curso,
                semestre: semestre,
                turno: turno,
                horarios: arrayhorarios
            },
            success: function (data) {
                console.log(data);
            },
            error: function () {
                //console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

</script>
