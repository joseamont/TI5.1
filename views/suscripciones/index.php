<?php

use app\models\Suscripciones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SuscripcionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Suscripciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suscripciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Suscripciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'precio',
            'resolucion',
            'dispositivos',
            //'duracion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {contratar}',
                'buttons' => [
                    'contratar' => function ($url, $model) {
                        if (Yii::$app->user->identity->id_rol == 4) {
                            return Html::a(
                                'Contratar', 
                                ['suscripciones/contratar', 'id' => $model->id], // Asegurar que coincide con el controlador correcto
                                [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quieres contratar este plan?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        }
                        return '';
                    },
                ],
            ],
            
            
        ],
    ]); ?>


</div>
