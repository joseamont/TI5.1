<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Accion;
use app\models\Seccion;

use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\AccionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="accion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row border bg-light">
        <div class="col-sm-1 my-auto">
            <div class="form-group ">
                <?= Html::submitButton('Filtrar', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
            </div>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'nombre') ?>
        </div>

        <div class="col-sm-3">
            <?php
            $s = ArrayHelper::map(Seccion::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_seccion')->dropDownList($s, ['prompt' => 'Seleccionar'])->label('Sección');
            ?>
        </div>

        <div class="col-sm-3">
            <?php
            echo $form->field($model, 'estatus')->dropDownList(['0' => 'Deshabilitado', '1' => 'Habilitado'], ['prompt' => 'Seleccionar']);
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>