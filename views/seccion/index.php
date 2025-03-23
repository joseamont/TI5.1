<?php

use app\models\Seccion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

use yii\data\SqlDataProvider;
use app\models\Permiso;

if (!Permiso::seccion('seccion')) {
    return $this->render('/site/error', [
        'name' => 'Permiso denegado',
        'message' => 'No tiene permiso para realizar esta función, verifique con el administrador de sistemas.'
    ]);
}
$form = '';

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Secciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seccion-index">

    <h3> <?= Html::encode($this->title) ?>
    </h3>
    <hr>
    <p>
        <?php
        /** Verificar permiso */
        if (Permiso::accion('seccion', 'create')) {
         //   echo Html::a('Nueva sección', ['create'], ['class' => 'btn btn-outline-success btn-sm']);

         echo Html::a('Nueva sección', ['#'], [
            'class' => 'btn  btn-sm btn-outline-success',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#modalForm',
        ]);
        
        $form = $this->render('_form', ['model' => new Seccion(), 'accion' => 'create']);
        }
        ?>
    </p>


    <?= GridView::widget([
        /** dataProvider poblado con una vista - _directorio_secciones */
        'dataProvider' => new SqlDataProvider(['sql' => 'SELECT * FROM _directorio_secciones']),
        /** Formado de botones de paginación */
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'firstPageLabel' => 'Inicio ',
            'lastPageLabel' => ' Último',
        ],
        'columns' => [
            [
                'attribute' => 'Secciones',
                'format' => 'raw',
                'value' => function ($model) {
                    $seccion = $model['ruta'];

                    /** Verificar permiso */
                    if (Permiso::accion('seccion', 'view')) {
                        $seccion = Html::a(
                            $model['ruta'],
                            ['/seccion/view', 'id' => $model['id_seccion']],
                            ['class' => 'btn btn-outline-dark btn-sm ' . ($model['estatus_seccion'] ? 'btn-warning' : '')]
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
                    $seccionEstatus = $model['estatus_seccion'] ? 'Habilitado' : 'Deshabilitado';

                    /** Verificar permiso */
                    if (Permiso::accion('seccion', 'update-estatus')) {
                        return Html::beginForm(['/seccion/update-estatus', 'id' => $model['id_seccion']])
                            . Html::hiddenInput('Seccion[estatus]', $model['estatus_seccion'] ? 0 : 1)
                            . Html::submitButton(
                                $model['estatus_seccion'] ? 'Deshabilitar' : 'Habilitar',
                                ['class' => 'btn btn-outline-secondary btn-sm']
                            )
                            . Html::endForm();
                    }
                    return $seccionEstatus;
                }
            ],
        ],
    ]);
    ?>

</div>

<!-- Modal donde se presenta _form para crear un nuevo rol  -->
<div class="modal fade modal-xl" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-info">
                <h3 class="modal-title" id="modalFormLabel">
                    Nueva sección
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