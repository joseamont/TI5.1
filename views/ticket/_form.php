<?php

use app\models\Suscripciones;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Asistencia;
use app\models\UsuarioPla;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */
/** @var yii\widgets\ActiveForm $form */
?>


    <div class="ticket-form">
<?php     
    $form = ActiveForm::begin(['action' => [$accion, 'id' => $model->id]]);
 ?>

<?= $form->field($model, 'id_usuario')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

<div class="col-sm-3">
    <?php
    // Obtener los planes contratados por el usuario actual
    $planesContratados = UsuarioPla::find()
        ->select('id_suscripcion')
        ->where(['id_usuario' => Yii::$app->user->id])
        ->andWhere(['not', ['id_suscripcion' => null]])
        ->column();
    
    // Obtener las suscripciones correspondientes a los planes contratados
    $suscripciones = Suscripciones::find()
        ->where(['id' => $planesContratados])
        ->all();
    
    // Mapear para el dropdown
    $listaSuscripciones = ArrayHelper::map($suscripciones, 'id', 'nombre');
    
    echo $form->field($model, 'id_suscripcion')
        ->dropDownList($listaSuscripciones, ['prompt' => 'Seleccionar'])
        ->label('Plan');
    ?>
</div>

    <?= $form->field($model, 'tipo')->dropDownList([ 'Estado de Suscripción' => 'Estado de Suscripción', 'Problemas de Reproducción' => 'Problemas de Reproducción', 'Informe de Reembolsos y Soporte' => 'Informe de Reembolsos y Soporte', 'Otros' => 'Otros', ], ['prompt' => '']) ?>


    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>


    <br>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-outline-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
