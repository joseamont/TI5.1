<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CalificacionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="calificacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_ticket') ?>

    <?= $form->field($model, 'id_usuario') ?>

    <?= $form->field($model, 'rapidez') ?>

    <?= $form->field($model, 'claridad') ?>

    <?php // echo $form->field($model, 'amabilidad') ?>

    <?php // echo $form->field($model, 'puntuacion') ?>

    <?php // echo $form->field($model, 'comentario') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
