<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PersonaInfo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="persona-info-form">

<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'persona-info-form',
    'enableAjaxValidation' => true,
]); ?>

<?= $form->field($model, 'id_persona')->hiddenInput()->label(false) ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'fecha_nacimiento')->widget(\yii\jui\DatePicker::class, [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
            'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => '1900:'.date('Y'),
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'genero')->dropDownList([
            'masculino' => 'Masculino',
            'femenino' => 'Femenino',
            'otro' => 'Otro'
        ], ['prompt' => 'Seleccionar']) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="form-group text-end">
    <?= Html::submitButton('<i class="bi bi-save-fill"></i> Guardar', ['class' => 'btn btn-primary']) ?>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>

</div>
