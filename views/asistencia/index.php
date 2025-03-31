<?php

use app\models\Asistencia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AsistenciaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Asistencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-striped'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
                        'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
                        'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                        'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                        'options' => ['class' => 'pagination justify-content-center'],
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled'],
                    ],
                    'layout' => "{items}\n<div class='row'><div class='col-md-6'>{summary}</div><div class='col-md-6'>{pager}</div></div>",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'header' => '#'],
            [
                'attribute' => 'Nombre del usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $usern = $model->user->getNombreUsuario();
                    return $usern;
                }
            ],
            'fecha',
            'hora_entrada',
            'hora_salida',
            'STATUS',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Asistencia $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
