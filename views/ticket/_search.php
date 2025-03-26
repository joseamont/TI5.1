<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\TicketSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ticket-search">

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<div class="row border bg-light">
    <div class="col-sm-1 my-auto">
        <div class="form-group ">
            <?= Html::submitButton('Filtrar', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
        </div>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'nombre') ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'apellidoPaterno') ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'apellidoMaterno') ?>
    </div>
    <div class="col-sm-2">
        <?php
        $i = ArrayHelper::map(User::find()->all(), 'id', 'nombre');
        echo $form->field($model, 'id_rol')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Rol');
        ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'username') ?>
    </div>
    <div class="col-sm-1">
        <?php
        echo $form->field($model, 'estatus')->dropDownList(['0' => 'Deshabilitado', '1' => 'Habilitado'], ['prompt' => 'Seleccionar']);
        ?>
    </div>
</div>
</div>

<?php ActiveForm::end(); ?>

</div>