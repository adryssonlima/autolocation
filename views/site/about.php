<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Sobre o Class Location';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    
    <div class="row">
        <h1 style="float:left;"><i class="fa fa-info-circle" aria-hidden="true"></i> <?= Html::encode($this->title) ?></span>
    </div>

    <!--<p> Uma breve descrição da aplicação </p> -->
    <br><br><br>

    <p>
        O <b>Centro Universitário Estácio do Ceará Campus Parangaba</b> dispõe de uma numerosa
        gama de cursos, dentre eles cursos de bacharelado e tecnólogos. As disciplinas
        são alocadas nas salas e laboratórios, definindo assim os horários das turmas,
        de modo que não hajam choques de disciplinas,
        levando em consideração também a disponibilidade de professores e outros fatores
        específicos.
    </p>
    <p>
        Diante deste desafio o <b>Class Location</b>, sistema desenvolvido por alunos do campus, auxilia
        a alocação de disciplinas nas salas do campus.
    </p>

    <br><br><br>

    <p> <b> <i class="fa fa-code" aria-hidden="true"></i> Conheça os Desenvolvedores</b> </p>
    <p>
    <img class="user-image" src="<?= \yii\helpers\Url::to("@web/css/profile-me-adrysson.jpg") ?>" class="circle profile">
    <a href="http://adryssonlima.github.io/" target="_blank"> Adrysson Lima <i class="fa fa-github" aria-hidden="true"></i> </a> | 
    <a href="mailto:adrysson.lima@gmail.com?Subject=ClassLocation%20again" target="_top">adrysson.lima@gmail.com <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
    <br>
    <img class="user-image" src="<?= \yii\helpers\Url::to("@web/css/profile-me-josh.jpg") ?>" class="circle profile">
    <a href="http://github.com/stakahou" target="_blank"> Joshua Ben Rabi <i class="fa fa-github" aria-hidden="true"></i> </a> | 
    <a href="mailto:benrabi@gmail.com?Subject=ClassLocation%20again" target="_top">benrabi@gmail.com <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
    </p>

</div>

<style>

    p {
        text-align: justify;
        text-justify: inter-word;
    }

    .user-image {
        margin-bottom: 1.2em;
        position: relative;
        width: 50px;
        height: 50px;
        border: 3px solid #3EA6CE;
        border-radius: 100%;
    }

</style>