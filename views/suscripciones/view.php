<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

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