<?php

use app\models\Seccion;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Rol;

/** @var yii\web\View $this */
/** @var app\models\Seccion $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="seccion-form">

    <?php
    $form = ActiveForm::begin(['action' => [$accion, 'id' => $model->id]]);
    ?>

    <div class="row border bg-light">

        <div class="col-sm-3">
            <?php
            $i = ArrayHelper::map(Seccion::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_seccion_superior')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Sección superior');
            ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'identificador')->textInput(['maxlength' => true]) ?>
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