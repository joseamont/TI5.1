<?php

/** @var yii\web\View $this */

$this->title = 'Genesia - Streaming';
?>
<div class="site-index">

<?php if (!Yii::$app->user->isGuest): ?>
    
    <div class="jumbotron text-center bg-transparent mt-4 mb-4">
        <h1 class="display-4">Bienvenido a Genesia Dashboard</h1>
        <p class="lead">Dashboard para trabajadores del sistema tecnico Genesia</p>
    </div>

    <div class="body-content">

    <div id="genesiaCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Primer gráfico -->
            <div class="carousel-item active">
                <div class="d-flex justify-content-center">
                    <canvas id="chartUsuarios" style="width: 80%; height: 300px;"></canvas>
                </div>
            </div>
            <!-- Segundo gráfico -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <canvas id="chartSuscripciones" style="width: 80%; height: 300px;"></canvas>
                </div>
            </div>
            <!-- Tercer gráfico -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <canvas id="chartPeliculas" style="width: 80%; height: 300px;"></canvas>
                </div>
            </div>
            <!-- Cuarto gráfico (Calificaciones de Usuarios) -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <canvas id="chartCalificacionesUsuarios" style="width: 80%; height: 300px;"></canvas>
                </div>
            </div>
            <!-- Quinto gráfico (Promedio de Calificaciones por Mes) -->
            <div class="carousel-item">
                <div class="d-flex justify-content-center">
                    <canvas id="chartPromedioCalificaciones" style="width: 80%; height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#genesiaCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#genesiaCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <!-- Sección de tablas -->
    <div class="row mt-5">
        <!-- Tabla de Novedades de Tickets -->
        <div class="col-md-6">
            <h4 class="text-center">📌 Novedades de Tickets</h4>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1001</td>
                        <td>Juan Pérez</td>
                        <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                        <td>2025-03-18</td>
                    </tr>
                    <tr>
                        <td>1002</td>
                        <td>Ana Gómez</td>
                        <td><span class="badge bg-success">Resuelto</span></td>
                        <td>2025-03-17</td>
                    </tr>
                    <tr>
                        <td>1003</td>
                        <td>Carlos Ramírez</td>
                        <td><span class="badge bg-danger">Cerrado</span></td>
                        <td>2025-03-16</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Notificaciones -->
        <div class="col-md-6">
            <h4 class="text-center">🔔 Notificaciones Recientes</h4>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>5001</td>
                        <td>Nuevo ticket asignado a soporte.</td>
                        <td>2025-03-18</td>
                    </tr>
                    <tr>
                        <td>5002</td>
                        <td>Actualización de políticas de privacidad.</td>
                        <td>2025-03-17</td>
                    </tr>
                    <tr>
                        <td>5003</td>
                        <td>Nuevo contenido agregado en la plataforma.</td>
                        <td>2025-03-16</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Incluir Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dataUsuarios = [120, 150, 180, 220, 250, 300];
            const dataSuscripciones = [50, 70, 90, 110, 130, 160];
            const dataPeliculas = [30, 45, 60, 80, 95, 120];
            const dataCalificacionesUsuarios = [300, 450, 500, 620, 700, 850]; // Cantidad de calificaciones dadas por usuarios
            const dataPromedioCalificaciones = [3.5, 4.0, 4.2, 4.5, 4.6, 4.8]; // Promedio de calificación por mes

            let charts = {}; // Objeto para guardar los gráficos

            function crearGrafico(idCanvas, label, data, color, type = 'line') {
                let ctx = document.getElementById(idCanvas).getContext('2d');

                // Si ya existe un gráfico en este canvas, lo destruimos antes de crear otro
                if (charts[idCanvas]) {
                    charts[idCanvas].destroy();
                }

                charts[idCanvas] = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
                        datasets: [{
                            label: label,
                            data: data,
                            borderColor: color,
                            backgroundColor: color + '33',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: true }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            // Crear el gráfico inicial (el primer slide)
            crearGrafico('chartUsuarios', 'Usuarios Registrados', dataUsuarios, '#0C4B54');

            // Evento que se activa cuando cambia el slide
            document.getElementById('genesiaCarousel').addEventListener('slid.bs.carousel', function (event) {
                let activeIndex = event.to;
                if (activeIndex === 0) {
                    crearGrafico('chartUsuarios', 'Usuarios Registrados', dataUsuarios, '#0C4B54');
                } else if (activeIndex === 1) {
                    crearGrafico('chartSuscripciones', 'Suscripciones Activas', dataSuscripciones, '#E8F549');
                } else if (activeIndex === 2) {
                    crearGrafico('chartPeliculas', 'Películas Vistas', dataPeliculas, '#FF5733');
                } else if (activeIndex === 3) {
                    crearGrafico('chartCalificacionesUsuarios', 'Calificaciones de Usuarios', dataCalificacionesUsuarios, '#1ABC9C', 'bar');
                } else if (activeIndex === 4) {
                    crearGrafico('chartPromedioCalificaciones', 'Promedio de Calificaciones', dataPromedioCalificaciones, '#9B59B6', 'line');
                }
            });
        });
    </script>
<?php endif; ?>


<?php if (!Yii::$app->user->isGuest): ?>
    <?php
    // Obtener el ID del rol del usuario autenticado
    $usuario = Yii::$app->user->identity;
    $rolId = $usuario->id_rol; // Asegúrate de que la columna en la BD sea 'rol_id'
    ?>

    <?php if ($rolId == 4): ?>
        <!-- Contenido exclusivo para usuarios con rol ID 4 -->
        <div class="container mt-4">
            <h3 class="text-center mb-4">📺 Últimos capítulos de Acción y Terror</h3>
            <div class="row">
                <!-- Serie 1 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/300x200/?action,movie" class="card-img-top" alt="Acción">
                        <div class="card-body">
                            <h5 class="card-title">🔥 Explosión Total</h5>
                            <p class="card-text">Episodio 5 - "La última misión".</p>
                            <a href="#" class="btn btn-primary">Ver ahora</a>
                        </div>
                    </div>
                </div>

                <!-- Serie 2 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/300x200/?horror,movie" class="card-img-top" alt="Terror">
                        <div class="card-body">
                            <h5 class="card-title">👻 No mires atrás</h5>
                            <p class="card-text">Episodio 8 - "Susurros en la oscuridad".</p>
                            <a href="#" class="btn btn-danger">Ver ahora</a>
                        </div>
                    </div>
                </div>

                <!-- Serie 3 -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/300x200/?zombies,movie" class="card-img-top" alt="Zombies">
                        <div class="card-body">
                            <h5 class="card-title">🧟‍♂️ Infierno Viviente</h5>
                            <p class="card-text">Episodio 3 - "Noche sin escapatoria".</p>
                            <a href="#" class="btn btn-dark">Ver ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Contenido para los demás usuarios -->
        <div class="jumbotron text-center bg-transparent mt-4 mb-4">
            <h1 class="display-4">Bienvenido a Genesia Streaming</h1>
            <p class="lead">Tu plataforma de entretenimiento multiplataforma con miles de títulos.</p>
        </div>

        <div class="body-content">
            <div id="genesiaCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center">
                            <canvas id="chartUsuarios" style="width: 80%; height: 300px;"></canvas>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center">
                            <canvas id="chartSuscripciones" style="width: 80%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#genesiaCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#genesiaCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>




                <!-- Controles del carrusel (solo para invitados, oculto si logeado) -->
                <?php if (Yii::$app->user->isGuest): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#genesiaCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#genesiaCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                <?php endif; ?>
            </div>

            <?php if (Yii::$app->user->isGuest): ?>
    <div id="guestCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Primer slide -->
            <div class="carousel-item active">
                <img src="https://images.pexels.com/photos/10464454/pexels-photo-10464454.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Explora Genesia">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Explora Genesia</h5>
                    <p>Descubre lo mejor del cine y la televisión, sin necesidad de iniciar sesión.</p>
                </div>
            </div>
            <!-- Segundo slide -->
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/10464475/pexels-photo-10464475.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Accede al entretenimiento">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Accede a lo mejor del entretenimiento</h5>
                    <p>Explora películas, series y más. ¡Suscríbete para acceder a contenido exclusivo!</p>
                </div>
            </div>
            <!-- Tercer slide -->
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/6065463/pexels-photo-6065463.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Únete a Genesia">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Únete a Genesia</h5>
                    <p>Suscríbete y accede a contenido exclusivo y estrenos.</p>
                </div>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#guestCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#guestCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
<?php endif; ?>
