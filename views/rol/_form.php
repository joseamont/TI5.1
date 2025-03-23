<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Rol $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="rol-form">

    <?php
    $form = ActiveForm::begin(['action' => [$accion, 'id' => $model->id]]);
    ?>
    <div class="row border bg-light">
        <div class="col-sm-8">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'estatus')->dropDownList(['0' => 'Deshabilitado', '1' => 'Habilitado'], ['prompt' => 'Seleccionar']) ?>
        </div>
    </div>
    <br>
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-outline-success btn-sm']) ?>
    <?php ActiveForm::end(); ?>

</div>