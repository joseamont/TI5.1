<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Rol;
use app\models\Seccion;
use app\models\Accion;

/** @var yii\web\View $this */
/** @var app\models\Privilegio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="privilegio-form">

    <?php
    $form = ActiveForm::begin(['action' => [$accion, 'id' => $model->id]]);
    ?>

    <div class="row border bg-light">
        <div class="col-sm-3">
            <?php
            $i = ArrayHelper::map(Rol::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_rol')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Rol');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $i = ArrayHelper::map(Seccion::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_seccion')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Sección');
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $i = ArrayHelper::map(Accion::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_accion')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Acción');
            ?>
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