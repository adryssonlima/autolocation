<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = 'Auto Location';
?>
<div class="site-index">

	<h1>Painel de Turmas</h1>

    <div class="container painel">
    <!--    <article> -->
            <div class="table-clientes">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th  style="color:white; width: 300px;"><i class="fa fa-university"></i> Curso</th>
                            <th  style="color:white; width: 300px;"><i class="fa fa-graduation-cap"></i> Turma</th>
                            <th  style="color:white; width: 300px;"><i class="fa fa-book"></i> Disciplina</th>
                            <th  style="color:white; width: 300px;"><i class="fa fa-location-arrow"></i> Sala</th>
                            <th  style="color:white; width: 300px;"><i class="fa fa-clock-o"></i> Horário</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="first_colum" rowspan="2">Análise e Desenvolvimento de Sistemas</td>
                            <td class="second_colum"><span class="label label-primary">ADS 2017.2</span></td>
                            <td class="last_colum">Implementação de Banco de Dados</td>
                            <td class="second_colum">PGB F02</td>
                            <td class="last_colum">A-B 7:30 às 9:20</td>
                        </tr>
						<tr>
						    <td class="second_colum"><span class="label label-primary">ADS 2016.1</span></td>
						    <td class="last_colum">Introdução a Programação</td>
						    <td class="second_colum">PGB F01</td>
							<td class="last_colum">A-B 7:30 às 9:20</td>
						</tr>
                        <tr>
                            <td class="first_colum">Administração</td>
                            <td class="second_colum"><span class="label label-primary">ADM 2017.2</span></td>
                            <td class="last_colum">Teoria Geral da Administração I</td>
                            <td class="second_colum">PGB F05</td>
                            <td class="last_colum">C-D 9:30 às 11:00</td>
                        </tr>
                        <tr>
                            <td class="first_colum">Redes de Computadores</td>
                            <td class="second_colum"><span class="label label-primary">REDES 2017.2</span></td>
                            <td class="last_colum">Inglês Técnico</td>
                            <td class="second_colum">PGB E05</td>
                            <td class="last_colum">A-B 7:30 às 9:20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
 <!--       </article> -->
    </div>





<!--

    <div class="row" id="cards">
        <div class="col-sm-3" v-for="(item,index) in turmas">
            <div class="panel panel-info" style="border-style: solid; border-width: 3px;">
                <div class="panel-heading"><b style="font-size: 170%">{{item.turma}}</b></div>
                <div class="panel-body">
                    <p><b>{{item.disciplina}}</b></p>
                    <p><b>{{item.sala}}</b></p>
                </div>
            </div>
        </div>
    </div>
-->
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/web/js/socket.io-1.4.5.js"></script>
<script>
    $(function () {
        var socket = io.connect('http://127.0.0.1:3000');
        socket.on('listagem de turmas', function(turmas){
            console.log(turmas);
            new Vue({
                el: '#cards',
                data: {
                    turmas
                }
            });
        });
    });
</script>

<style>

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


</style>
