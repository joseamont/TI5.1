<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="calificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'calificacion')->textInput([
        'type' => 'number',
        'min' => 1,
        'max' => 10,
        'step' => 1,
        'placeholder' => 'Calificación del 1 al 10',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Calificación', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
