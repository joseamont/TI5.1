<?php

use app\models\UsuarioTic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuarioTicSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuario Tics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-tic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuario Tic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_usuario',
            'id_ticket',
            'fecha_insercion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{detalle}', // Solo dejamos este botón personalizado
                'buttons' => [
                    'detalle' => function ($url, $model) {
                        return Html::a(
                            'Ver Respuesta', 
                            ['ticket/ver-respuesta', 'id' => $model->id], // Llama a la nueva acción
                            [
                                'class' => 'btn btn-info btn-sm',
                            ]
                        );
                    },
                ],
            ], 
        ],
    ]); ?>


</div>
