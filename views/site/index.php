<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = 'Auto Location';
?>
<div class="site-index">

    <div class="body-content">
        <h1>Painel de Turmas</h1>

        <ul id='turmas'></ul>

    </div>

</div>

<script src="js/socket.io-1.4.5.js"></script>
<script>
    $(function () {
        var socket = io.connect('http://127.0.0.1:3000');
        socket.on('listagem de turmas', function(data){
            console.log(data);
            $('#turmas').append('<li>'+data[0].nome+'</li>');
        });
    });
</script>
