<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Calificacion $model */

$this->title = "Calificación #".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

// Obtener el id_rol del usuario actual
$user = Yii::$app->user->identity;
$mostrarBotonPDF = true;

if ($user && $user->id_rol == 4) {
    $mostrarBotonPDF = false;
}

// Registrar Chart.js
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css');
?>
<div class="calificacion-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #0C4B54;">
            <i class="bi bi-star-fill me-2"></i><?= Html::encode($this->title) ?>
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

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Detalles de la Calificación</h5>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id_ticket',
                                'value' => $model->ticket ? $model->ticket->tipo : 'No especificado',
                            ],
                            [
                                'attribute' => 'id_usuario',
                                'value' => $model->usuario ? $model->usuario->getNombreUsuario() : 'No especificado',
                            ],
                            [
                                'label' => 'Operador',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $nombre = $model->getIdUsuarioFromUsuarioTic();
                                    return Html::tag('div', $nombre, ['class' => 'fw-semibold']);
                                },
                                'contentOptions' => ['style' => 'min-width: 150px;']
                            ],
                            [
                                'attribute' => 'fecha',
                                'format' => ['date', 'php:d/m/Y H:i:s'],
                            ],
                            [
                                'attribute' => 'comentario',
                                'format' => 'ntext',
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Puntuaciones</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <canvas id="radarChart" height="200"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <canvas id="barChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para los gráficos
    const data = {
        labels: ['Rapidez', 'Claridad', 'Amabilidad', 'Puntuación General'],
        datasets: [{
            label: 'Calificación',
            data: [<?= $model->rapidez ?>, <?= $model->claridad ?>, <?= $model->amabilidad ?>, <?= $model->puntuacion ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuración común
    const config = {
        scales: {
            y: {
                beginAtZero: true,
                max: 5,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Gráfico de radar
    new Chart(
        document.getElementById('radarChart'),
        {
            type: 'radar',
            data: data,
            options: {
                ...config,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        }
    );

    // Gráfico de barras
    new Chart(
        document.getElementById('barChart'),
        {
            type: 'bar',
            data: data,
            options: config
        }
    );
});
</script>

<!-- Script para generar PDF (solo se carga si el botón es visible) -->
<?php if ($mostrarBotonPDF): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('download-pdf').addEventListener('click', async function() {
    // Mostrar spinner de carga
    const originalButtonText = this.innerHTML;
    this.innerHTML = '<i class="bi bi-hourglass me-2"></i> Generando PDF...';
    this.disabled = true;
    
    try {
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
        
        // Título
        doc.setFontSize(16);
        doc.setTextColor(255, 255, 255);
        doc.setFont('helvetica', 'bold');
        doc.text('Reporte de Calificación', pageWidth / 2, 12, { align: 'center' });
        
        // Fecha
        doc.setFontSize(10);
        doc.text('Generado: ' + new Date().toLocaleDateString(), pageWidth - margin, 12, { align: 'right' });
        
        y = 30;
        
        // --- TÍTULO DEL DOCUMENTO ---
        doc.setFontSize(18);
        doc.setTextColor(...primaryColor);
        doc.setFont('helvetica', 'bold');
        doc.text('<?= Html::encode($this->title) ?>', pageWidth / 2, y, { align: 'center' });
        y += 10;
        
        // Línea decorativa
        doc.setDrawColor(...secondaryColor);
        doc.setLineWidth(0.5);
        doc.line(margin, y, pageWidth - margin, y);
        y += 5;
        
        // --- INFORMACIÓN DE LA CALIFICACIÓN ---
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
        
        // Datos de la calificación
        addField('Ticket', '<?= $model->ticket ? addslashes($model->ticket->tipo) : "No especificado" ?>');
        addField('Usuario', '<?= $model->usuario ? addslashes($model->usuario->getNombreUsuario()) : "No especificado" ?>');
        addField('Fecha', '<?= Yii::$app->formatter->asDatetime($model->fecha) ?>');
        y += 5;
        
        // --- PUNTUACIONES ---
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(...primaryColor);
        doc.text('Puntuaciones:', margin, y);
        y += 5;
        
        // Tabla de puntuaciones
        const puntuaciones = [
            { label: 'Rapidez', value: '<?= $model->rapidez ?>' },
            { label: 'Claridad', value: '<?= $model->claridad ?>' },
            { label: 'Amabilidad', value: '<?= $model->amabilidad ?>' },
            { label: 'Puntuación General', value: '<?= $model->puntuacion ?>' }
        ];
        
        // Encabezado de la tabla
        doc.setFillColor(...primaryColor);
        doc.setTextColor(255, 255, 255);
        doc.rect(margin, y, pageWidth - margin * 2, 8, 'F');
        doc.text('Categoría', margin + 2, y + 5);
        doc.text('Puntuación', pageWidth - margin - 20, y + 5, { align: 'right' });
        y += 8;
        
        // Filas de la tabla
        doc.setTextColor(0, 0, 0);
        puntuaciones.forEach((item, index) => {
            // Fondo alternado para filas
            if (index % 2 === 0) {
                doc.setFillColor(240, 240, 240);
                doc.rect(margin, y, pageWidth - margin * 2, 8, 'F');
            }
            
            doc.text(item.label, margin + 2, y + 5);
            doc.text(item.value.toString(), pageWidth - margin - 20, y + 5, { align: 'right' });
            y += 8;
        });
        
        y += 10;
        
        // --- COMENTARIO ---
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(...primaryColor);
        doc.text('Comentario:', margin, y);
        y += 5;
        
        // Caja con fondo para el comentario
        doc.setFillColor(...lightColor);
        doc.rect(margin, y, pageWidth - margin * 2, 30, 'F');
        doc.setDrawColor(200, 200, 200);
        doc.rect(margin, y, pageWidth - margin * 2, 30);
        
        // Texto del comentario
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(0, 0, 0);
        const comentario = '<?= $model->comentario ? addslashes($model->comentario) : "Sin comentario" ?>';
        const splitComentario = doc.splitTextToSize(comentario, pageWidth - margin * 2 - 5);
        doc.text(splitComentario, margin + 3, y + 5);
        y += 35;
        
        // --- GRÁFICAS ---
        // Capturar las gráficas como imágenes
        try {
            // Título de la sección
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(...primaryColor);
            doc.text('Visualización de Puntuaciones:', margin, y);
            y += 10;
            
            // Gráfico de radar
            const radarCanvas = document.getElementById('radarChart');
            const radarImgData = await html2canvas(radarCanvas, {
                scale: 2, // Mejor calidad
                logging: false,
                useCORS: true
            }).then(canvas => canvas.toDataURL('image/png', 1.0));
            
            // Añadir gráfico de radar
            const radarWidth = pageWidth - margin * 2;
            const radarHeight = radarWidth * 0.6; // Mantener proporción
            doc.addImage(radarImgData, 'PNG', margin, y, radarWidth, radarHeight);
            y += radarHeight + 10;
            
            // Gráfico de barras
            const barCanvas = document.getElementById('barChart');
            const barImgData = await html2canvas(barCanvas, {
                scale: 2, // Mejor calidad
                logging: false,
                useCORS: true
            }).then(canvas => canvas.toDataURL('image/png', 1.0));
            
            // Añadir gráfico de barras
            const barWidth = pageWidth - margin * 2;
            const barHeight = barWidth * 0.6; // Mantener proporción
            doc.addImage(barImgData, 'PNG', margin, y, barWidth, barHeight);
            y += barHeight + 10;
            
        } catch (error) {
            console.error('Error al generar gráficas:', error);
            doc.text('No se pudieron incluir las gráficas en el PDF', margin, y);
            y += 10;
        }
        
        // --- PIE DE PÁGINA ---
        doc.setFontSize(10);
        doc.setTextColor(100, 100, 100);
        doc.setFont('helvetica', 'normal');
        doc.text('© ' + new Date().getFullYear() + ' Sistema de Calificaciones - Todos los derechos reservados', 
                pageWidth / 2, 290, { align: 'center' });
        
        // Guardar el PDF
        doc.save(`Calificacion_<?= $model->id ?>_${new Date().toISOString().slice(0,10)}.pdf`);
        
    } catch (error) {
        console.error('Error al generar PDF:', error);
        alert('Ocurrió un error al generar el PDF. Por favor intente nuevamente.');
    } finally {
        // Restaurar el botón
        document.getElementById('download-pdf').innerHTML = originalButtonText;
        document.getElementById('download-pdf').disabled = false;
    }
});
</script>
<?php endif; ?>

<style>
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        background-color: #f8f9fa;
    }
    
    .table th {
        width: 40%;
    }
    
    .btn-primary {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42;
        border-color: #0A3A42;
    }
    
    .fw-bold {
        color: #0C4B54;
    }
</style>