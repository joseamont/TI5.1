<?php

use app\models\Suscripciones;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Asistencia;

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
            $i = ArrayHelper::map(Suscripciones::find()->all(), 'id', 'nombre');
            echo $form->field($model, 'id_suscripcion')->dropDownList($i, ['prompt' => 'Seleccionar'])->label('Plan');
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
