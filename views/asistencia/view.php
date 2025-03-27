<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Asistencia;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\Asistencia $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Asistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="asistencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_usuario',
                'label' => 'Nombre de Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $username = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario'; 
                    
            
                    return $username;
                }
            ],
            'fecha',
            'hora_entrada',
            'hora_salida',
            'STATUS',
        ],
    ]) ?>

<h2>Otras Asistencias del Usuario</h2>

<?php
$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => Asistencia::find()->where(['id_usuario' => $model->id_usuario])->andWhere(['!=', 'id', $model->id]),
    'pagination' => ['pageSize' => 5], // Muestra 5 tickets por página
]);
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
       'id',
       [
        'attribute' => 'id_usuario',
        'label' => 'Nombre de Usuario',
        'format' => 'raw',
        'value' => function ($model) {
            $username = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario'; 
            
            /** Verificar permiso */
            if (Permiso::accion('asistencia', 'view')) {
                return Html::a(
                    $username,
                    ['view', 'id' => $model->id],
                    ['class' => 'btn btn-outline-dark btn-sm']
                );
            }
    
            return $username;
        }
    ],
            'fecha',
            'hora_entrada',
            'hora_salida',
    ],
]) ?>

</div>
