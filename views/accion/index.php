<?php

use app\models\Accion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

use app\models\Permiso;

/** @var yii\web\View $this */
/** @var app\models\AccionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

if (!Permiso::seccion('accion')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}

$form = '';

$this->title = 'Acciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accion-index">

    <h3> <?= Html::encode($this->title) ?>
    </h3>
    <hr>
    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('accion', 'create')) {
           // echo Html::a('Nueva acción', ['create'], ['class' => 'btn btn-outline-success btn-sm']);
        
           //  Crear un nuevo rol utilizando _form.php en el modal 'modalForm' de abajo
        echo Html::a('Nueva acción', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new Accion(), 'accion' => 'create']);
        }
        ?>
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <br>

    <?= GridView::widget([
        /** dataProvider poblado desde AccionController - actionIndex() */
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // Boton acción
            [
                'attribute' => 'Acción',
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
             // Botón Sección
             [
                'attribute' => 'Sección',
                'format' => 'raw',
                'value' => function ($model) {
                    $seccion = $model->seccion->getNombreEstatus();
                    /** Verificar permiso */
                    if (Permiso::accion('seccion', 'view')) {
                        $seccion = Html::a(
                            $model->seccion->getNombreEstatus(),
                            ['/seccion/view', 'id' => $model->id_seccion],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model->seccion->estatus ? 'btn-warning' : '')]
                        );
                    }

                    return $seccion;
                }
            ],
            //Boton habilitar
            [
                'attribute' => 'Estatus',
                'format' => 'raw',
                'value' => function ($model) {
                    $rolEstatus = $model->estatus ? 'Habilitado' : 'Deshabilitado';

                    /** Verificar permiso */
                    if (Permiso::accion('accion', 'update-estatus')) {
                        $rolEstatus = Html::beginForm(['update-estatus', 'id' => $model->id])
                            . Html::hiddenInput('Accion[estatus]', $model->estatus ? 0 : 1)
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
                    Nueva acción
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