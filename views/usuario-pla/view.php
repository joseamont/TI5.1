<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\UsuarioPla $model */

if (!Permiso::seccion('usuario_pla')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Planes contratados';
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="usuario-pla-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <?php if (Permiso::accion('usuario_pla', 'delete')): ?>
        <?= Html::a('Eliminar', '#', [
            'class' => 'btn btn-sm btn-outline-danger',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalMensaje',
            'onClick' => "
                $('#ModalLabelMensaje').text('Eliminar Rol');
                $('#ModalBodyMensaje').html('Confirmar que desea eliminar el rol: <b>" . Html::encode($model->suscripcion->nombre) . "</b>.<br> Si tiene asignados usuarios o privilegios primero deberá quitar la asignación.');
                $('#ModalButtonMensaje').attr('data-url', '" . Yii::$app->urlManager->createUrl(['usuario-pla/delete', 'id' => $model->id]) . "');
            ",
        ]) ?>
    <?php else: ?>
        <span class="text-muted">No tiene permiso para eliminar</span>
    <?php endif; ?>
</p>

<!-- Modal -->
<div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="ModalLabelMensaje" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabelMensaje"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ModalBodyMensaje"></div>
            <div class="modal-footer">
                <!-- El formulario POST para eliminar -->
                <?= Html::beginForm('', 'post', ['id' => 'deleteForm']) ?>
                    <a href="#" class="btn btn-danger" id="ModalButtonMensaje" data-url="">Confirmar</a>
                <?= Html::endForm() ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Actualizar la URL del formulario cuando se haga clic en el enlace de eliminación
    $('#ModalButtonMensaje').on('click', function () {
        var url = $(this).data('url');
        $('#deleteForm').attr('action', url);
        $('#deleteForm').submit();  // Enviar el formulario POST para eliminar
    });
</script>




    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_usuario',
                'label' => 'Usuario',
                'value' => function ($model) {
                    // Accede al usuario asociado usando la relación
                    return $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario';
                },
            ],
            [
                'attribute' => 'id_suscripcion',
                'label' => 'Suscripción',
                'value' => function ($model) {
                    // Accede a la suscripción asociada usando la relación
                    return $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción';
                },
            ],
            'fecha_insercion',
        ],
    ]) ?>

    <h2>Otras Suscripciones del Usuario</h2>

    <?php
    // Definir el DataProvider para obtener las otras suscripciones del mismo usuario, excluyendo el actual registro.
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => \app\models\UsuarioPla::find()
            ->where(['id_usuario' => $model->id_usuario]) // Filtra por el mismo id_usuario
            ->andWhere(['!=', 'id', $model->id]), // Excluye el registro actual
        'pagination' => [
            'pageSize' => 5, // Limitar el número de registros por página
        ],
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_suscripcion',
                'label' => 'Suscripción',
                'value' => function ($model) {
                    // Accede a la suscripción asociada usando la relación
                    return $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción';
                },
            ],
            [
                'attribute' => 'id_usuario',
                'label' => 'Usuario',
                'value' => function ($model) {
                    // Accede al usuario asociado usando la relación
                    return $model->usuario ? $model->usuario->getNombreUsuario() : 'Sin usuario';
                },
            ],
            'fecha_insercion',
        ],
    ]) ?>
</div>
