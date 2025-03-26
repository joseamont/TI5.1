<?php

use app\models\UsuarioCal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\UsuarioCalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('usuario_cal')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Calificaciones Trabajadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-cal-index">

<h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

<br><br>

<?= GridView::widget([
        /** dataProvider poblado desde UsuarioCalController - actionIndex() */
        'dataProvider' => $dataProvider,
        /** Formato de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'id_usuario',
                'label' => 'Nombre de Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario'; 
                    
                    /** Verificar permiso */
                    if (Permiso::accion('asistencia', 'view')) {
                        return Html::a(
                            $nombreUsuario,
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm']
                        );
                    }
            
                    return $nombreUsuario;
                }
            ],
            [
                'attribute' => 'calificacion',
                'label' => 'Calificación',
                'format' => 'raw',
                'value' => function ($model) {
                    // Consulta directa a la tabla UsuarioCal para obtener la calificación asociada
                    $usuarioCal = UsuarioCal::findOne(['id_usuario' => $model->id_usuario]);
                    
                    // Verificamos si existe una calificación asociada
                    if ($usuarioCal) {
                        return $usuarioCal->calificacion;
                    } else {
                        return 'Sin Calificación'; // En caso de que no haya calificación
                    }
                }
            ],
            
            'fecha_insercion',
        ],
    ]); ?>

