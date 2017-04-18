<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = 'Auto Location';
?>
<div class="site-index">

    <h1>Painel de Turmas</h1>

    <div class="row" id="cards">
        <div class="col-sm-3" v-for="(item,index) in turmas">
            <div class="panel panel-default">
                <div class="panel-heading">{{item.turma}}</div>
                <div class="panel-body">
                    <p>{{item.disciplina}}</p>
                    <p>{{item.sala}}</p>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="js/socket.io-1.4.5.js"></script>
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
