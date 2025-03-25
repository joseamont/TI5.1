<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Respuesta;
use app\models\Ticket;

/** @var yii\web\View $this */
/** @var app\models\Respuesta $model */

$this->title = "Conversación del Ticket #" . $model->id_ticket;
$this->params['breadcrumbs'][] = ['label' => 'Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="respuesta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="chat-container">
    <?php Pjax::begin(); ?> <!-- Permite actualizar el chat sin recargar la página -->

    <?php
    use app\models\User; // Asegura que estás usando el modelo de usuario

    $respuestas = Respuesta::find()->where(['id_ticket' => $model->id_ticket])->orderBy(['fecha' => SORT_ASC])->all();
    foreach ($respuestas as $respuesta) :
        $usuario = User::findOne($respuesta->id_usuario); // Busca el usuario por su ID
        $nombreUsuario = $usuario ? $usuario->username : 'Usuario desconocido'; // Si no encuentra el usuario, muestra un mensaje genérico
    ?>
        <div class="chat-message <?= ($respuesta->id_usuario == Yii::$app->user->id) ? 'sent' : 'received' ?>">
            <div class="message-header">
                <strong><?= $respuesta->id_usuario == Yii::$app->user->id ? 'Tú' : Html::encode($nombreUsuario) ?></strong>
                <span class="message-time"><?= date('d/m/Y H:i', strtotime($respuesta->fecha)) ?></span>
            </div>
            <div class="message-body">
                <?= Html::encode($respuesta->respuesta) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php Pjax::end(); ?>
</div>


    <!-- Formulario para responder -->
    <div class="chat-form">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['respuesta/create']),
        'options' => ['data-pjax' => true]
    ]); ?>

    <?= $form->field(new Respuesta(), 'id_ticket')->hiddenInput(['value' => $model->id_ticket])->label(false) ?>
    <?= $form->field(new Respuesta(), 'id_usuario')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
    <?= $form->field(new Respuesta(), 'respuesta')->textarea(['rows' => 2, 'placeholder' => 'Escribe tu respuesta...'])->label(false) ?>

    <div class="form-group">
        <?php 
        // Obtener el ticket relacionado con el id_ticket
        $ticket = Ticket::findOne($model->id_ticket);
        
        // Verificar si el ticket está cerrado
        $disabled = ($ticket && $ticket->status == 'cerrado') ? true : false;

        // Si el ticket está cerrado, desactivar el botón
        echo Html::submitButton('Enviar', [
            'class' => 'btn btn-primary',
            'disabled' => $disabled, // Desactivar el botón si el ticket está cerrado
        ]);
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


</div>

<style>
    .chat-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 10px;
        overflow-y: auto;
        max-height: 400px;
    }

    .chat-message {
        padding: 10px;
        margin: 10px 0;
        border-radius: 10px;
        width: fit-content;
        max-width: 80%;
    }

    .chat-message.sent {
        background: #d1e7dd;
        align-self: flex-end;
        text-align: right;
    }

    .chat-message.received {
        background: #f8d7da;
        align-self: flex-start;
        text-align: left;
    }

    .message-header {
        font-size: 12px;
        color: #555;
        margin-bottom: 5px;
    }

    .message-time {
        font-size: 10px;
        color: #999;
        float: right;
    }

    .chat-form {
        margin-top: 20px;
        text-align: center;
    }
</style>
