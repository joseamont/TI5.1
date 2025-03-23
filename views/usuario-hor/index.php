<?php

use app\models\UsuarioHor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\UsuarioHorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuario Hors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-hor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuario Hor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'id_usuario',
                'label' => 'Nombre de Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $username = $model->user ? $model->user->username : 'Sin usuario'; 
                    
                }
            ],
            'id_horario',
            'fecha_insercion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UsuarioHor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
