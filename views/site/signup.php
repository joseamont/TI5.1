<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SignupForm $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="user-form">
    <?php $form = ActiveForm::begin(['action' => ['signup/create']]); ?>

    <div class="row border bg-light p-3">
        <div class="col-sm-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => 50]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => 50]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => 50]) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 80]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 45]) ?>
        </div>

        <!-- Campo Estatus oculto (por defecto 1) -->
        <?= $form->field($model, 'estatus')->hiddenInput(['value' => 1])->label(false) ?>
    </div>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-outline-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
