<?php

use app\models\Respuesta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\RespuestaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('respuesta')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Respuestas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-index">

    <br><br>
    <?= GridView::widget([
        /** dataProvider poblado desde RolController - actionIndex() */
        'dataProvider' => $dataProvider,
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_ticket',
            'id_usuario',
            'respuesta:ntext',
            'fecha',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Respuesta $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
