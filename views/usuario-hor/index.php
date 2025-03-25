<?php

use app\models\UsuarioHor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Permiso;
use app\models\User;


/** @var yii\web\View $this */
/** @var app\models\UsuarioHorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('usuario_hor')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Horario Trabajador';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-hor-index">

<h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

    <?php
    /** Verificar permiso */
    if (Permiso::accion('usuario_hor', 'create')) {

        //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
        echo Html::a('Nuevo usuario horario', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new UsuarioHor(), 'accion' => 'create']);
    }
    ?>


<br><br>

<?= GridView::widget([
        /** dataProvider poblado desde TicketController - actionIndex() */
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
            [
                'attribute' => 'id_usuario',
                'label' => 'Nombre de Usuario',
                'format' => 'raw',
                'value' => function ($model) {
                    $username = $model->user ? $model->user->username : 'Sin usuario'; 
                    
                    /** Verificar permiso */
                    if (Permiso::accion('usuario_hor', 'view')) {
                        return Html::a(
                            $username,
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm']
                        );
                    }
            
                    return $username;
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
