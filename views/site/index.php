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
            <div class="panel panel-info" style="border-style: solid; border-width: 3px;">
                <div class="panel-heading"><b style="font-size: 170%">{{item.turma}}</b></div>
                <div class="panel-body">
                    <p><b>{{item.disciplina}}</b></p>
                    <p><b>{{item.sala}}</b></p>
                </div>
            </div>
        </div>
    </div>

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
