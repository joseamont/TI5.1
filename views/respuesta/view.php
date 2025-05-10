<?php

use app\models\Calificacion;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Respuesta;
use app\models\Ticket;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\Respuesta $model */

if (!Permiso::seccion('respuesta')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$this->title = "Conversación del Ticket #" . $model->id_ticket;
$this->params['breadcrumbs'][] = ['label' => 'Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Get ticket status
$ticket = Ticket::findOne($model->id_ticket);
$isClosed = ($ticket && $ticket->status == 'cerrado');
$currentUser = Yii::$app->user->identity;
$alreadyRated = Calificacion::find()->where(['id_ticket' => $model->id_ticket, 'id_usuario' => $currentUser->id])->exists();
?>
<div class="respuesta-view">

    <div class="chat-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>

        <?php if ($isClosed && $currentUser->id_rol == 4 && !$alreadyRated): ?>
        <?= Html::button('<i class="bi bi-star me-2"></i> Calificar Servicio', [
            'class' => 'btn btn-success btn-lg',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalCalificacion',
        ]) ?>
    <?php endif; ?>

            <?php if ($isClosed): ?>
                <span class="badge badge-status closed">Cerrado</span>
            <?php else: ?>
                <span class="badge badge-status open">Abierto</span>
            <?php endif; ?>
            
        </div>
    </div>

    <div class="chat-container-wrapper">
        <div class="chat-container">
            <?php Pjax::begin(['id' => 'chat-messages']); ?>
            
            <?php
            $respuestas = Respuesta::find()
                ->where(['id_ticket' => $model->id_ticket])
                ->orderBy(['fecha' => SORT_ASC])
                ->all();
            
            foreach ($respuestas as $respuesta) :
                $usuario = User::findOne($respuesta->id_usuario);
                $nombreUsuario = $usuario ? $usuario->username : 'Usuario desconocido';
                $isCurrentUser = ($respuesta->id_usuario == Yii::$app->user->id);
            ?>
                <div class="chat-message <?= $isCurrentUser ? 'sent' : 'received' ?>">
                    <div class="message-avatar">
                        <?= strtoupper(substr($nombreUsuario, 0, 1)) ?>
                    </div>
                    <div class="message-content">
                        <div class="message-header">
                            <strong><?= $isCurrentUser ? 'Tú' : Html::encode($nombreUsuario) ?></strong>
                            <span class="message-time"><?= Yii::$app->formatter->asDatetime($respuesta->fecha, 'php:d/m/Y H:i') ?></span>
                        </div>
                        <div class="message-body">
                            <?= Html::encode($respuesta->respuesta) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php Pjax::end(); ?>
        </div>
    </div>

    <!-- Response Form -->
    <div class="chat-form-container">
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['respuesta/create']),
            'options' => [
                'data-pjax' => true,
                'class' => 'chat-form'
            ]
        ]); ?>

        <?= $form->field(new Respuesta(), 'id_ticket')->hiddenInput(['value' => $model->id_ticket])->label(false) ?>
        <?= $form->field(new Respuesta(), 'id_usuario')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
        
        <div class="form-group">
            <?= $form->field(new Respuesta(), 'respuesta', [
                'template' => "{input}\n{error}",
                'options' => ['class' => 'message-input-container']
            ])->textarea([
                'rows' => 3, 
                'placeholder' => 'Escribe tu respuesta aquí...',
                'class' => 'form-control message-input',
                'disabled' => $isClosed
            ])->label(false) ?>
        </div>

        <div class="form-group text-right">
            <?= Html::submitButton('Enviar', [
                'class' => 'btn btn-send',
                'disabled' => $isClosed
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
        <?php if ($isClosed): ?>
            <div class="alert alert-info mt-3">
                Este ticket está cerrado. No se pueden enviar más respuestas.
            </div>
        <?php endif; ?>
    </div>

    <!-- Botón para calificar (solo si el usuario tiene id_rol 4 y el ticket está cerrado y no ha calificado aún) -->


    <!-- Modal de calificación -->
    <div class="modal fade" id="modalCalificacion" tabindex="-1" aria-labelledby="modalCalificacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCalificacionLabel">Calificar Ticket #<?= $model->id_ticket ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'action' => Url::to(['calificacion/create']),
                        'method' => 'post',
                    ]); ?>

                    <?= Html::hiddenInput('Calificacion[id_ticket]', $model->id_ticket) ?>
                    <?= Html::hiddenInput('Calificacion[id_usuario]', $currentUser->id) ?>

                    <?= $form->field(new Calificacion(), 'rapidez')->dropDownList([1 => 'Muy lento', 2 => 'Lento', 3 => 'Regular', 4 => 'Rápido', 5 => 'Muy rápido'], ['prompt' => 'Selecciona una opción']) ?>
                    <?= $form->field(new Calificacion(), 'claridad')->dropDownList([1 => 'Poco claro', 2 => 'Algo claro', 3 => 'Regular', 4 => 'Claro', 5 => 'Muy claro'], ['prompt' => 'Selecciona una opción']) ?>
                    <?= $form->field(new Calificacion(), 'amabilidad')->dropDownList([1 => 'Poco amable', 2 => 'Algo amable', 3 => 'Regular', 4 => 'Amable', 5 => 'Muy amable'], ['prompt' => 'Selecciona una opción']) ?>
                    <?= $form->field(new Calificacion(), 'puntuacion')->dropDownList([1 => '1 estrella', 2 => '2 estrellas', 3 => '3 estrellas', 4 => '4 estrellas', 5 => '5 estrellas'], ['prompt' => 'Selecciona una opción']) ?>
                    <?= $form->field(new Calificacion(), 'comentario')->textarea(['rows' => 3, 'placeholder' => 'Agrega un comentario sobre el servicio...']) ?>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <?= Html::submitButton('Enviar Calificación', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>



<!-- Resto del código CSS y JS permanece igual -->

<style>
    :root {
        --primary-color: #0C4B54;
        --secondary-color: #E8F549;
        --sent-message-bg: #DCF8C6;
        --received-message-bg: #FFFFFF;
        --text-color: #333333;
        --light-text: #777777;
        --border-color: #E1E1E1;
        --avatar-size: 36px;
    }
    
    .respuesta-view {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .chat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .chat-header h1 {
        font-size: 1.5rem;
        margin: 0;
        color: var(--primary-color);
    }
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .badge-status.open {
        background-color: #D4EDDA;
        color: #155724;
    }
    
    .badge-status.closed {
        background-color: #F8D7DA;
        color: #721C24;
    }
    
    .chat-container-wrapper {
        background: #F5F7FA;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .chat-container {
        max-height: 500px;
        overflow-y: auto;
        padding: 10px;
    }
    
    .chat-message {
        display: flex;
        margin-bottom: 15px;
    }
    
    .chat-message.sent {
        flex-direction: row-reverse;
    }
    
    .message-avatar {
        width: var(--avatar-size);
        height: var(--avatar-size);
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        flex-shrink: 0;
        margin-top: 5px;
    }
    
    .message-content {
        max-width: 70%;
        margin: 0 10px;
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .message-header strong {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .message-time {
        font-size: 0.75rem;
        color: var(--light-text);
    }
    
    .message-body {
        padding: 12px 15px;
        border-radius: 12px;
        line-height: 1.4;
        word-break: break-word;
    }
    
    .chat-message.sent .message-body {
        background-color: var(--sent-message-bg);
        border-top-right-radius: 0;
    }
    
    .chat-message.received .message-body {
        background-color: var(--received-message-bg);
        border-top-left-radius: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .chat-form-container {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .message-input-container {
        margin-bottom: 15px;
    }
    
    .message-input {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        resize: none;
        transition: border-color 0.3s;
    }
    
    .message-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(12, 75, 84, 0.1);
    }
    
    .btn-send {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: background-color 0.3s;
    }
    
    .btn-send:hover {
        background-color: #0A3A42;
        color: white;
    }
    
    .btn-send:disabled {
        background-color: #CCCCCC;
        cursor: not-allowed;
    }
    
    /* Custom scrollbar */
    .chat-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-container::-webkit-scrollbar-track {
        background: #F1F1F1;
        border-radius: 3px;
    }
    
    .chat-container::-webkit-scrollbar-thumb {
        background: #C1C1C1;
        border-radius: 3px;
    }
    
    .chat-container::-webkit-scrollbar-thumb:hover {
        background: #A8A8A8;
    }
</style>

<?php
// Auto-scroll to bottom of chat
$this->registerJs(<<<JS
    $(document).ready(function() {
        var chatContainer = $('.chat-container');
        chatContainer.scrollTop(chatContainer[0].scrollHeight);
        
        // Refresh chat every 30 seconds if ticket is open
        if (!$('.badge-status.closed').length) {
            setInterval(function() {
                $.pjax.reload({container: '#chat-messages', async: false});
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }, 30000);
        }
    });
JS
);
?>