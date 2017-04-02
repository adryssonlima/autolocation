
//Function para o lançamento de modais
function modalAjax(url, titulo, csrftoken) {
    $.ajax({
        url: url,
        type: 'post',
        data: {
            _csrf: csrftoken
        },
        success: function (data) {
            $(".modal-titulo").html(titulo);
            $(".modal-conteudo").html(data);
            $("#modal").modal("show");
        },
        error: function () {
            console.log("Erro ao submeter requisição Ajax");
        }
    });
}

//Function para pegar os semestres de um curso especícifo. Usado pela page disciplina.
function getSemestres(url, curso, csrftoken) {
    $.ajax({
        url: url,
        type: 'post',
        data: {
            _csrf: csrftoken,
            id: curso
        },
        success: function (data) {
            //console.log(data);
            $("#disciplina-semestre_ref").empty();
            for (i = 1; i <= data; i++) {
                $("#disciplina-semestre_ref").append($("<option></option>").attr("value", i).text(i));
            }
        },
        error: function () {
            console.log("Erro ao submeter requisição Ajax");
        }
    });
}
