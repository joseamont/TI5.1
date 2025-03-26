<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Ticket;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_usuario',
                'label' => 'Nombre de Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    // Usamos la función getNombreUsuario() para obtener el nombre completo
                    $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario'; 
                    
            
                    return $nombreUsuario;
                }
            ],
            [
                'attribute' => 'id_suscripcion',
                'label' => 'Nombre del Plan',
                'format' => 'raw',
                'value' => function ($model) {
                    // Acceder a la relación suscripcion y obtener el nombre del plan
                    $nombrePlan = $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción';
            
                    // Verificar si el usuario tiene permiso y si hay una suscripción
                    if ($model->suscripcion && Permiso::accion('suscripciones', 'view')) {
                        // Crear el enlace solo si el usuario tiene permiso
                        return Html::a(
                            $nombrePlan,
                            ['suscripciones/view', 'id' => $model->id_suscripcion],
                            ['class' => 'btn btn-outline-primary btn-sm']
                        );
                    }
            
                    // Si no hay suscripción o no hay permiso, solo mostrar el nombre
                    return $nombrePlan;
                }
            ],
            
            
            'tipo',
            'fecha_apertura',
            'fecha_cierre',
            'status',
            'descripcion:ntext',
            'id_calificacion',
        ],
    ]) ?>

    <h2>Otros Tickets del Usuario</h2>

    <?php
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => Ticket::find()->where(['id_usuario' => $model->id_usuario])->andWhere(['!=', 'id', $model->id]),
        'pagination' => ['pageSize' => 5], // Muestra 5 tickets por página
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'tipo',
            'fecha_apertura',
            'fecha_cierre',
            'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>

</div>
