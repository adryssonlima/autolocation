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
            <label class="control-label" for="usuario-password-confirm">Confirmar Senha</label>
            <input type="password" id="usuario-password-confirm" class="form-control" maxlength="80" aria-required="true">
            <div class="flag hidden">Senhas diferentes</div>
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

    $("#submit").click(function(event){
        event.preventDefault();
        let pass = $("#usuario-password").val();
        let passconfirm = $("#usuario-password-confirm").val();
        if (pass == passconfirm) {
            $(".flag").addClass('hidden');
            $.ajax({
                url: '<?= Yii::$app->request->baseUrl . '/usuario/create' ?>',
                type: 'post',
                data: {
                    nome: $("#usuario-nome").val(),
                    email: $("#usuario-email").val(),
                    senha: $("#usuario-password").val(),
                    tipo: $("#usuario-tipo option:selected").val()
                },
                success: function (data) {
                    console.log(data);
                },
                error: function () {
                    console.log("Erro ao submeter requisição Ajax");
                }
            });
        } else {
            $(".flag").removeClass('hidden');
        }
    });

</script>
