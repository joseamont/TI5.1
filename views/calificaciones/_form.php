<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Calificaciones $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="calificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'calificacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
