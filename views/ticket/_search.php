<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Ticket;

/** @var yii\web\View $this */
/** @var app\models\TicketSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline'
        ]
    ]); ?>

    <div class="row mb-3 p-3" style="background-color: #f8f9fa; border-radius: 5px;">
        <div class="col-md-2">
            <?= $form->field($model, 'id')->textInput(['placeholder' => 'ID Ticket']) ?>
        </div>
        
        <div class="col-md-2">
            <?= $form->field($model, 'tipo')->dropDownList(
                Ticket::getTipos(), 
                ['prompt' => 'Todos los tipos']
            ) ?>
        </div>
        
        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropDownList(
                [
                    'abierto' => 'Abierto',
                    'cerrado' => 'Cerrado',
                    'pendiente' => 'Pendiente'
                ],
                ['prompt' => 'Todos los estados']
            ) ?>
        </div>
        
        <div class="col-md-2">
            <?= $form->field($model, 'id_usuario')->dropDownList(
                ArrayHelper::map(User::find()->all(), 'id', 'username'),
                ['prompt' => 'Todos los usuarios']
            ) ?>
        </div>
        
        <div class="col-md-2">
            <?= $form->field($model, 'fecha_apertura')->input('date') ?>
        </div>
        
        <div class="col-md-2 d-flex align-items-end">
            <div class="form-group">
                <?= Html::submitButton('<i class="bi bi-funnel"></i> Filtrar', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="bi bi-arrow-counterclockwise"></i>', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>