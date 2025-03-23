<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Horario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="horario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dias')->dropDownList([ 'Lunes-Viernes' => 'Lunes-Viernes', 'sabado-domingo' => 'Sabado-domingo', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'hora_inicio')->textInput() ?>

    <?= $form->field($model, 'hora_fin')->textInput() ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'matutino' => 'Matutino', 'vespertino' => 'Vespertino', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
