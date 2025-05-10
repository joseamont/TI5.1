<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UsuarioTic $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuario-tic-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    // Obtener todos los usuarios con id_rol = 3
    $usuarios = \app\models\User::find()
        ->where(['id_rol' => 3])
        ->all();
    
    // Crear array para el dropdown [id => username]
    $listaUsuarios = [];
    foreach ($usuarios as $usuario) {
        $listaUsuarios[$usuario->id] = $usuario->username; // Mostrar el username
    }
    
    // Mostrar el dropdown
    echo $form->field($model, 'id_usuario')->dropDownList(
        $listaUsuarios,
        ['prompt' => 'Seleccione un usuario']
    );
    ?>

    <?= $form->field($model, 'id_ticket')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'fecha_insercion')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
