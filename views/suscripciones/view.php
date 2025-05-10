<?php

use app\models\Suscripciones;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Suscripciones $model */
/** @var app\models\User[] $usuarios */

$this->title = 'Detalles de Suscripción: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Suscripciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nombre;
\yii\web\YiiAsset::register($this);
?>
<div class="suscripciones-view container mt-4">

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0"><?= Html::encode($this->title) ?></h1>
                <?php if (Permiso::accion('suscripciones', 'update')): ?>
                        <?= Html::a(
                            '<i class="bi bi-eye-fill me-1"></i> Actualizar Horario', 
                            ['update', 'id' => $model->id],
                            ['class' => 'btn btn-sm btn-info']
                        ) ?>
                    <?php endif; ?>
            <?php $form = $this->render('_form', ['model' => new Suscripciones(), 'accion' => 'create']); ?>
            </div>
        </div>
        
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'nombre',
                    [
                        'attribute' => 'precio',
                        'value' => function($model) {
                            return Yii::$app->formatter->asCurrency($model->precio);
                        }
                    ],
                    [
                        'attribute' => 'resolucion',
                        'value' => function($model) {
                            return Html::tag('span', $model->resolucion, ['class' => 'badge bg-info']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'dispositivos',
                        'value' => function($model) {
                            return $model->dispositivos . ' dispositivo(s) simultáneo(s)';
                        }
                    ],
                    [
                        'attribute' => 'duracion',
                        'value' => function($model) {
                            return $model->duracion . ' mes(es)';
                        }
                    ],
                ],
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
            ]) ?>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h2 class="h5 mb-0">Usuarios con este plan</h2>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => new yii\data\ArrayDataProvider([
                    'allModels' => $model->usuarios,
                    'key' => 'id',
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]),
                'tableOptions' => ['class' => 'table table-hover'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    [
                        'label' => 'Nombre Completo',
                        'value' => function ($model) {
                            return Html::encode($model->getNombreUsuario());
                        },
                    ],
                    'username',
                ],
                'emptyText' => 'No hay usuarios asociados a este plan.',
                'summary' => 'Mostrando <b>{begin}-{end}</b> de <b>{totalCount}</b> usuarios',
                'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
            ]); ?>
        </div>
    </div>
</div>

<!-- Modal para crear nuevo ticket -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background-color: #0C4B54;">
                <h5 class="modal-title" id="modalFormLabel">
                    <i class="bi bi-plus-circle me-2"></i> Nuevo Ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= $form ?>
            </div>
        </div>
    </div>
</div>

<?php
// Agregar estilos CSS adicionales
$css = <<<CSS
.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
}
.card-header {
    padding: 1rem 1.5rem;
}
.detail-view th {
    width: 25%;
}
CSS;
$this->registerCss($css);
?>