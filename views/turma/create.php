<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = 'Nova Turma';
//$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-create">

    <!--<h1><?= ''//Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

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

    $('#conf-dados-turma').click(function() {
        var turno = $('#turma-turno').val();
        createTabelaHorario(turno);
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
                //ocupados[5] = "41";
                console.log(ocupados);

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
                            arrayHorariosChoque.push(v);
                        }
                    });
                });

                if (!arrayHorariosChoque.length) {
                    //console.log('pode salvar');
                    createTurmaHorario(identificador, curso, semestre, turno, arrayhorarios);
                } else {
                    //console.log('horarios com choque');
                    arrayHorariosChoque.forEach(function(v, i){
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
        $.ajax({
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
                $('#'+periodo['id']).append("<td id='td" + dia['id']+periodo['id'] + "' class='tdhover'> <span class='info-turma-disciplina-sala' id='span" + dia['id']+periodo['id'] + "'></span> <a id='link" + dia['id']+periodo['id'] + "' id_dia='" + dia['id'] + "' id_periodo='" + periodo['id'] + "' href='#' class='pull-right text-success' title='Editar'> <span class='glyphicon glyphicon-pencil'></span> </a> </td>");
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
                var dados = $.parseJSON(data);
                console.log(dados);
                $("#table-horario").find("span").text("");
                $.each(dados, function(index, value) {
                    $("#span"+value).text("Sem Salas Disponíveis").css('color', 'red');
                    $("#td"+value).css('text-align','center');
                    $("#link"+value).remove();
                });
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
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
                var salas = dados.salas;
                var disciplinas = dados.disciplinas;

                if (salas.length == 0) {
                    $("#span"+dia+periodo).text("Sem Salas Disponíveis").css('color', 'red');
                    $("#td"+dia+periodo).css('text-align','center');
                    $("#link"+dia+periodo).remove();
                    $("#linkremove"+dia+periodo).remove();
                } else {
                    $("#modal-sala").empty();
                    $.each(salas, function(index, value) {
                        $("#modal-sala").append($("<option></option>").attr("value", index).text(value));
                    });
                    $("#modal-disciplina").empty();
                    $.each(disciplinas, function(index, value) {
                        $("#modal-disciplina").append($("<option></option>").attr("value", index).text(value));
                    });
                    $("#myModal").modal('show');
                }
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function createTurmaHorario(identificador, curso, semestre, turno, arrayhorarios) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl . '/turma/nova-turma' ?>',
            type: 'post',
            data: {
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
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

</script>
