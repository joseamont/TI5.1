<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Ticket;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_usuario',
            'id_suscripcion',
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
