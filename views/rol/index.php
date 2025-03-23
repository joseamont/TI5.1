<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Rol;
use app\models\Permiso;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
if (!Permiso::seccion('rol')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-index">
    <h3> <?= Html::encode($this->title) ?> </h3>
    <hr>

    <?php
    /** Verificar permiso */
    if (Permiso::accion('rol', 'create')) {

        //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
        echo Html::a('Nuevo rol', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new Rol(), 'accion' => 'create']);
    }
    ?>

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
            // Boton rol
            [
                'attribute' => 'Rol',
                'format' => 'raw',
                'value' => function ($model) {
                    $rol = $model->getNombreEstatus();

                    /** Verificar permiso */
                    if (Permiso::accion('rol', 'view')) {
                        $rol = Html::a(
                            $model->getNombreEstatus(),
                            ['view', 'id' => $model->id],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $rol;
                }
            ],
            [
                'attribute' => 'Relacionado',
                'format' => 'raw',
                'value' => function($model){
                    return 'Usuarios ('.( $model->users?count($model->users):'0').') - '.
                    'Privilegios ('.( $model->privilegios?count($model->privilegios):'0').') ';
                }
            ],
            //Boton habilitar
            [
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {
                    $rolEstatus = $model->estatus ? 'Habilitado' : 'Deshabilitado';

                    /** Verificar permiso */
                    if (Permiso::accion('rol', 'update-estatus')) {
                        $rolEstatus = Html::beginForm(['update-estatus', 'id' => $model->id])
                            . Html::hiddenInput('Rol[estatus]', $model->estatus ? 0 : 1)
                            . Html::submitButton(
                                $model->estatus ? 'Deshabilitar' : 'Habilitar',
                                ['class' => 'btn btn-outline-secondary btn-sm']
                            )
                            . Html::endForm();
                    }

                    return $rolEstatus;
                }
            ],
        ],
    ]); ?>


</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-lg" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nuevo rol
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <div id="modalFormBody">
                    <?= $form; ?>
                </div>
            </div>
        </div>
    </div>
</div>