<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Rol;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php     
    $form = ActiveForm::begin(['action' => [$accion, 'id' => $model->id]]);
 ?>

    <div class="row border bg-light">
        <div class="col-sm-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => 50]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'apellidoPaterno')->textInput(['maxlength' => 50]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'apellidoMaterno')->textInput(['maxlength' => 50]) ?>
        </div>


        <div class="col-sm-3">
            <?php
            $i = ArrayHelper::map(Rol::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_rol')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Rol');
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'username')->textInput(['maxlength' => 80]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 10]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'estatus')->dropDownList(['0' => 'Deshabilitado', '1' => 'Habilitado'], ['prompt' => 'Seleccionar']) ?>
        </div>

    </div>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-outline-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>