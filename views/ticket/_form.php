<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ticket-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'id_suscripcion')->textInput() ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'Estado de Suscripción' => 'Estado de Suscripción', 'Problemas de Reproducción' => 'Problemas de Reproducción', 'Informe de Reembolsos y Soporte' => 'Informe de Reembolsos y Soporte', 'Otros' => 'Otros', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'fecha_apertura')->textInput() ?>

    <?= $form->field($model, 'fecha_cierre')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'sin abrir' => 'Sin abrir', 'abierto' => 'Abierto', 'cerrado' => 'Cerrado', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_calificacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
