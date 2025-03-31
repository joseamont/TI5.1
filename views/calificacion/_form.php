<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Calificacion $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="calificacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_ticket')->textInput() ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'rapidez')->textInput() ?>

    <?= $form->field($model, 'claridad')->textInput() ?>

    <?= $form->field($model, 'amabilidad')->textInput() ?>

    <?= $form->field($model, 'puntuacion')->textInput() ?>

    <?= $form->field($model, 'comentario')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
