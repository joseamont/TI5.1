<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Rol;
use app\models\Seccion;
use app\models\Accion;

/** @var yii\web\View $this */
/** @var app\models\PrivilegioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="privilegio-search">

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
            <?php 
                $r = ArrayHelper::map(Rol::find()->all(), 'id', 'nombre' );
                echo $form->field($model, 'id_rol')->dropDownList($r,['prompt'=>'Seleccionar'])->label('Rol'); 
            ?>
        </div>

        <div class="col-sm-3">
            <?php 
                $s = ArrayHelper::map(Seccion::find()->all(), 'id', 'nombre' );
                echo $form->field($model, 'id_seccion')->dropDownList($s,['prompt'=>'Seleccionar'])->label('Sección'); 
            ?>
        </div>
        <div class="col-sm-3">
            <?php 
                $a = ArrayHelper::map(Accion::find()->all(), 'id', 'nombre' );
                echo $form->field($model, 'id_accion')->dropDownList($a,['prompt'=>'Seleccionar'])->label('Acción'); 
            ?>
        </div>
       
        <div class="col-sm-2">
            <?php
                echo $form->field($model, 'estatus')->dropDownList([ '0' => 'Deshabilitado', '1' => 'Habilitado'], ['prompt' => 'Seleccionar']);
            ?>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>

</div>
