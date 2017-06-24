<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['type' => 'email', 'maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <label class="control-label password-confirm" for="usuario-password-confirm">Confirmar Senha</label>
            <input type="password" id="usuario-password-confirm" class="form-control password-confirm" maxlength="80" aria-required="true">
            <div class="flag flag-pass hidden">Senhas diferentes!</div>
        </div>
    </div>

    <?= $form->field($model, 'tipo')->dropDownList(['administrador' => 'Administrador', 'usuario' => 'Usuario']) ?>

    <div class="form-group pull-right acoes">
        <?= Html::button("<i class='fa fa-times' aria-hidden='true'></i> Cancelar", ['class' => 'btn btn-default', "data-dismiss" => "modal"]) ?>
        <?= Html::submitButton($model->isNewRecord ? "<i class='fa fa-check' aria-hidden='true'></i> Criar" : "<i class='fa fa-check' aria-hidden='true'></i> Alterar", ['id' => 'submit', 'class' => $model->isNewRecord ? 'btn btn-success aplicar' : 'btn btn-primary aplicar']) ?>
        <input type="hidden" class="remover-bnt-confirmar" name="remover" value="false" />
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
    </div>
    <br><br>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .flag {
        color: red;
    }
</style>

<script>

    $('.field-usuario-email').find('.help-block').removeClass('help-block').addClass('flag flag-email hidden').text('Email inválido!');

    $("#submit").click(function(event){
        event.preventDefault();
        if ( $('.remover-bnt-confirmar').val() == 'true' ) {
            let action = '/usuario/delete?id=' + '<?= $model->id ?>';
            reqAjax(action);
        } else if ( validateEmail() && validatePass() ) {
            let action = '<?= $model->isNewRecord ? '/usuario/create' : '/usuario/update?id='.$model->id ?>';
            reqAjax(action);
        }
    });

    function reqAjax(action) {
        $.ajax({
            url: '<?= Yii::$app->request->baseUrl ?>'+action,
            type: 'post',
            data: {
                nome: $("#usuario-nome").val(),
                email: $("#usuario-email").val(),
                password: $("#usuario-password").val(),
                tipo: $("#usuario-tipo option:selected").val()
            },
            success: function (data) {
                console.log(data);
            },
            error: function () {
                console.log("Erro ao submeter requisição Ajax");
            }
        });
    }

    function validateEmail() {
        var email = $("#usuario-email").val();
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
            $(".flag-email").removeClass('hidden');
            return false;
        }
        $(".flag-email").addClass('hidden');
        return true;
    }

    function validatePass() {
        let pass = $("#usuario-password").val();
        let passconfirm = $("#usuario-password-confirm").val();
        if (pass != passconfirm) {
            $(".flag-pass").removeClass('hidden');
            return false;
        }
        $(".flag-pass").addClass('hidden');
        return true;
    }

</script>
