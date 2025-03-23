<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Suscripciones $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="suscripciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resolucion')->dropDownList([ 'SD' => 'SD', 'HD' => 'HD', 'Full HD' => 'Full HD', '4K' => '4K', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'dispositivos')->textInput() ?>

    <?= $form->field($model, 'duracion')->dropDownList([ 'mensual' => 'Mensual', 'trimestral' => 'Trimestral', 'anual' => 'Anual', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
