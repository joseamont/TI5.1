<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Ticket;
use app\models\Permiso;
use Yii;

/** @var yii\web\View $this */
/** @var app\models\Ticket $model */

$this->title = 'Ticket #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Obtener el id_rol del usuario actual
$user = Yii::$app->user->identity;
$mostrarBotonPDF = true;

if ($user && $user->id_rol == 4) {
    $mostrarBotonPDF = false;
}
?>
<div class="ticket-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-ticket-detailed me-2"></i><?= Html::encode($this->title) ?>
        </h1>
        <!-- Botón para descargar PDF (solo visible si no es rol 4) -->
        <?php if ($mostrarBotonPDF): ?>
            <?= Html::button('<i class="bi bi-file-earmark-pdf-fill me-2"></i> Exportar a PDF', [
                'class' => 'btn btn-success',
                'id' => 'download-pdf',
                'style' => 'background-color: #0C4B54; border-color: #0C4B54;'
            ]) ?>
        <?php endif; ?>
    </div>

    <!-- Resto del código se mantiene igual -->
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #0C4B54;">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <h5 class="card-title mb-0 fw-bold" style="color: #0C4B54;">
                <i class="bi bi-info-circle me-2"></i>Detalles del Ticket
            </h5>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'id_usuario',
                        'label' => 'Nombre de Usuario',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $nombreUsuario = $model->user ? $model->user->getNombreUsuario() : 'Sin usuario';
                            return Html::tag('span', $nombreUsuario, ['class' => 'badge', 'style' => 'background-color: #0C4B54; color: white;']);
                        }
                    ],
                    [
                        'attribute' => 'id_suscripcion',
                        'label' => 'Nombre del Plan',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $nombrePlan = $model->suscripcion ? $model->suscripcion->nombre : 'Sin suscripción';
                            
                            if ($model->suscripcion && Permiso::accion('suscripciones', 'view')) {
                                return Html::a(
                                    $nombrePlan,
                                    ['suscripciones/view', 'id' => $model->id_suscripcion],
                                    ['class' => 'btn btn-sm', 'style' => 'background-color: #E8F549; color: #0C4B54;']
                                );
                            }
                            
                            return Html::tag('span', $nombrePlan, ['class' => 'badge', 'style' => 'background-color: #E8F549; color: #0C4B54;']);
                        }
                    ],
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::tag('span', $model->tipo, ['class' => 'badge bg-primary']);
                        }
                    ],
                    'fecha_apertura',
                    'fecha_cierre',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                            $statusClass = $model->status == 'Abierto' ? 'bg-success' : 'bg-secondary';
                            return Html::tag('span', $model->status, ['class' => 'badge '.$statusClass]);
                        }
                    ],
                    'descripcion:ntext',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card shadow-sm" style="border-left: 4px solid #0C4B54;">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <h5 class="card-title mb-0 fw-bold" style="color: #0C4B54;">
                <i class="bi bi-list-ul me-2"></i>Otros Tickets del Usuario
            </h5>
        </div>
        <div class="card-body">
            <?php
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => Ticket::find()->where(['id_usuario' => $model->id_usuario])->andWhere(['!=', 'id', $model->id]),
                'pagination' => ['pageSize' => 5],
            ]);
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover mb-0'],
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'header' => '#'],
                    [
                        'attribute' => 'tipo',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::tag('span', $model->tipo, ['class' => 'badge bg-primary']);
                        }
                    ],
                    'fecha_apertura',
                    'fecha_cierre',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                            $statusClass = $model->status == 'Abierto' ? 'bg-success' : 'bg-secondary';
                            return Html::tag('span', $model->status, ['class' => 'badge '.$statusClass]);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Acciones',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'class' => 'btn btn-sm',
                                    'style' => 'background-color: #0C4B54; color: white;',
                                    'title' => 'Ver detalles'
                                ]);
                            },
                        ],
                        'visible' => Permiso::accion('ticket', 'view'),
                    ],
                ],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'firstPageLabel' => '<i class="bi bi-chevron-double-left"></i>',
                    'lastPageLabel' => '<i class="bi bi-chevron-double-right"></i>',
                    'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
                    'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
                    'options' => ['class' => 'pagination justify-content-center mt-3'],
                    'linkOptions' => ['class' => 'page-link'],
                ],
            ]) ?>
        </div>
    </div>
</div>


<!-- Script para generar PDF (solo se carga si el botón es visible) -->
<?php if ($mostrarBotonPDF): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.getElementById('download-pdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4'
    });
    
    // Configuración
    const pageWidth = doc.internal.pageSize.getWidth();
    const margin = 15;
    const lineHeight = 7;
    let y = margin;
    
    // Colores corporativos
    const primaryColor = [12, 75, 84]; // #0C4B54
    const secondaryColor = [232, 245, 73]; // #E8F549
    const lightColor = [248, 249, 250]; // #f8f9fa
    
    // --- ENCABEZADO ---
    doc.setFillColor(...primaryColor);
    doc.rect(0, 0, pageWidth, 20, 'F');
    
    // Logo o título
    doc.setFontSize(16);
    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.text('Sistema de Gestión de Tickets', pageWidth / 2, 12, { align: 'center' });
    
    // Fecha
    doc.setFontSize(10);
    doc.text('Generado: ' + new Date().toLocaleDateString(), pageWidth - margin, 12, { align: 'right' });
    
    y = 30;
    
    // --- TÍTULO DEL DOCUMENTO ---
    doc.setFontSize(18);
    doc.setTextColor(...primaryColor);
    doc.setFont('helvetica', 'bold');
    doc.text(`Detalles del Ticket #${'<?= $model->id ?>'}`, pageWidth / 2, y, { align: 'center' });
    y += 10;
    
    // Línea decorativa
    doc.setDrawColor(...secondaryColor);
    doc.setLineWidth(0.5);
    doc.line(margin, y, pageWidth - margin, y);
    y += 5;
    
    // --- INFORMACIÓN DEL TICKET ---
    doc.setFontSize(12);
    
    // Función para agregar campos
    function addField(label, value, isImportant = false) {
        // Etiqueta
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(...primaryColor);
        doc.text(`${label}:`, margin, y);
        
        // Valor
        doc.setFont('helvetica', isImportant ? 'bold' : 'normal');
        doc.setTextColor(0, 0, 0);
        const splitText = doc.splitTextToSize(value, pageWidth - margin * 2 - 40);
        doc.text(splitText, margin + 40, y);
        
        y += (splitText.length * lineHeight);
    }
    
    // Datos del ticket
    addField('Usuario', '<?= $model->user ? addslashes($model->user->getNombreUsuario()) : "Sin usuario" ?>');
    addField('Plan', '<?= $model->suscripcion ? addslashes($model->suscripcion->nombre) : "Sin suscripción" ?>');
    addField('Tipo', '<?= $model->tipo ?>');
    addField('Fecha Apertura', '<?= $model->fecha_apertura ?>');
    addField('Fecha Cierre', '<?= $model->fecha_cierre ?>');
    
    // Estado con estilo especial
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...primaryColor);
    doc.text('Estado:', margin, y);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor('<?= $model->status == "Abierto" ? "#28a745" : "#6c757d" ?>');
    doc.text('<?= $model->status ?>', margin + 40, y);
    y += lineHeight;
    
    // Calificación
    addField('Calificación', '<?= $model->id_calificacion ?>');
    y += 5;
    
    // --- DESCRIPCIÓN ---
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...primaryColor);
    doc.text('Descripción:', margin, y);
    y += 5;
    
    // Caja con fondo para la descripción
    doc.setFillColor(...lightColor);
    doc.rect(margin, y, pageWidth - margin * 2, 50, 'F');
    doc.setDrawColor(200, 200, 200);
    doc.rect(margin, y, pageWidth - margin * 2, 50);
    
    // Texto de descripción
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(0, 0, 0);
    const description = '<?= $model->descripcion ? addslashes($model->descripcion) : "Sin descripción" ?>';
    const splitDescription = doc.splitTextToSize(description, pageWidth - margin * 2 - 5);
    doc.text(splitDescription, margin + 3, y + 5);
    y += 55;
    
    // --- PIE DE PÁGINA ---
    doc.setFontSize(10);
    doc.setTextColor(100, 100, 100);
    doc.setFont('helvetica', 'normal');
    doc.text('© ' + new Date().getFullYear() + ' Sistema de Tickets - Todos los derechos reservados', 
            pageWidth / 2, 290, { align: 'center' });
    
    // Guardar el PDF
    doc.save(`Ticket_${'<?= $model->id ?>'}_${new Date().toISOString().slice(0,10)}.pdf`);
});
</script>
<?php endif; ?>

<!-- Incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    .card {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #0C4B54;
        font-weight: 600;
        border-top: none;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    .bg-success {
        background-color: #28a745!important;
    }
    
    .bg-primary {
        background-color: #0C4B54!important;
    }
    
    .detail-view tr:last-child td {
        border-bottom: none;
    }
    
    .page-link {
        color: #0C4B54;
    }
    
    .page-item.active .page-link {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    /* Estilos para el botón de PDF */
    #download-pdf {
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
    }
    
    #download-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(12, 75, 84, 0.3);
        background-color: #0a3a42 !important;
    }
    
    #download-pdf i {
        margin-right: 8px;
    }
</style>