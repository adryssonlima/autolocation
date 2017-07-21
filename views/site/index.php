<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = 'Class Location';
?>
<div class="site-index">

	<h1><i class="fa fa-table" aria-hidden="true"></i> Painel de Turmas <span class="pull-right"><button class="btn btn-primary print" onclick="toggleFullScreen(document.getElementById('table-painel'))"><i class="fa fa-desktop" aria-hidden="true"></i> Modo de Exibição</button></span></h1>
    <br>
    <div class="container painel">
        <div class="table-clientes">
            <table id="table-painel" class="table table-striped">
                <thead>
                    <tr>
                        <th class="table-title"><i class="fa fa-university"></i> CURSO</th>
                        <th class="table-title"><i class="fa fa-graduation-cap"></i> TURMA</th>
                        <th class="table-title"><i class="fa fa-book"></i> DISCIPLINA</th>
                        <th class="table-title"><i class="fa fa-location-arrow"></i> SALA</th>
                        <th class="table-title"><i class="fa fa-clock-o"></i> HORÁRIO</th>
                    </tr>
                </thead>

                <tbody id="tbody">
                    <tr v-for="(item,index) in turmas">
                        <td class="td-label">{{item.curso}}</td>
                        <td class="td-label"><span class="label label-primary">{{item.turma}}</span></td>
                        <td class="td-label">{{item.disciplina}}</td>
                        <td class="td-label">{{item.sala}}</td>
                        <td class="td-label">{{item.horario}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="<?= Yii::$app->request->baseUrl ?>/web/js/socket.io-1.4.5.js"></script>
<script>
    $(function () {
        var socket = io.connect('http://127.0.0.1:3000');
        socket.on('listagem de turmas', function(turmas){
            if (!turmas.length) {
                $('#tbody').html('<tr class="aviso"><td>Sem aulas no momento.</td></tr>');
            } else {
                $('.aviso').remove();
                console.log(turmas);
                new Vue({
                    el: '#tbody',
                    data: {
                        turmas
                    }
                });
            }
            
        });
    });

    function toggleFullScreen(elem) {
        // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
            if (elem.requestFullScreen) {
                elem.requestFullScreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullScreen) {
                elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    }

</script>

<style>

html, body {
  background: white;
  padding: 0;
  margin: 0;
}

*:fullscreen
*:-ms-fullscreen,
*:-webkit-full-screen,
*:-moz-full-screen {
   overflow: auto !important;
}

div.painel {
    margin: 0;
    padding: 0;
    width: 100%;
    min-height: 100%;
    max-height: 100%;
    height: auto;
}

.table {
    background-color: #2d353c;
    color: white;
    border-collapse: collapse;
    border-radius: 3px;
}

.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color: rgba(45, 53, 60, 0.9);
}

tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}

.table-title {
    color: white;
}

.td-label {
    font-size: 130%;
}

</style>
