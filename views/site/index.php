<?php
/** @var yii\web\View $this */

$this->title = 'Genesia - Streaming';
?>

<div class="site-index">

<?php if (!Yii::$app->user->isGuest): ?>
    <?php
    // Obtener el ID del rol del usuario
    $usuario = Yii::$app->user->identity;
    $rolId = $usuario->id_rol;
    ?>

    <?php if ($rolId != 4): ?>
        <!-- Contenido para usuarios que NO tienen el rol 4 -->
        <div class="dashboard-header">
            <div class="container py-5">
                <h1 class="display-4 fw-bold text-white mb-3">Bienvenido a Genesia</h1>
                <p class="lead text-white-50 mb-4">Panel de control para el equipo técnico</p>
                
                <!-- Quick Stats -->
                <div class="row g-4 quick-stats">
                    <div class="col-md-3">
                        <div class="stat-card bg-primary">
                            <div class="stat-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="stat-content">
                                <h3>1,240</h3>
                                <p>Usuarios Activos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-success">
                            <div class="stat-icon">
                                <i class="bi bi-collection-play-fill"></i>
                            </div>
                            <div class="stat-content">
                                <h3>856</h3>
                                <p>Streams Hoy</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-warning">
                            <div class="stat-icon">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <div class="stat-content">
                                <h3>24</h3>
                                <p>Tickets Abiertos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-info">
                            <div class="stat-icon">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="stat-content">
                                <h3>4.8</h3>
                                <p>Rating Promedio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de actividad reciente -->
        <div class="container mt-5">
            <div class="row g-4">
                <!-- Tickets Table -->
                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-ticket-detailed me-2"></i>Novedades de Tickets</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1001</td>
                                            <td>Juan Pérez</td>
                                            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                            <td>2025-03-18</td>
                                            <td><button class="btn btn-sm btn-outline-primary">Ver</button></td>
                                        </tr>
                                        <tr>
                                            <td>1002</td>
                                            <td>Ana Gómez</td>
                                            <td><span class="badge bg-success">Resuelto</span></td>
                                            <td>2025-03-17</td>
                                            <td><button class="btn btn-sm btn-outline-primary">Ver</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="#" class="btn btn-primary">Ver todos los tickets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($rolId == 4): ?>
    <!-- Contenido exclusivo para usuarios con rol 4 -->
    <div class="dashboard-header bg-dark">
        <div class="container py-4">
            <h1 class="fw-bold text-white mb-2">Bienvenido a Genesia</h1>
            <p class="lead text-white-50 mb-0">Panel de control para el equipo técnico</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="section-header mb-4">
            <h2 class="fw-bold"><i class="bi bi-collection-play-fill me-2"></i>Últimos lanzamientos</h2>
            <p class="text-muted mb-0">Descubre lo nuevo en Genesia</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="https://image.tmdb.org/t/p/w500/74f2d3240bc60a44aa566433e0a3e25c.jpg" class="card-img-top" alt="Explosión Total">
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Nuevo</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">🔥 Explosión Total</h5>
                        <p class="card-text text-muted small">Episodio 5 - "La última misión"</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary">Ver ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="https://image.tmdb.org/t/p/w500/monkey-man-dev-patel.jpg" class="card-img-top" alt="No mires atrás">
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Nuevo</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">👻 No mires atrás</h5>
                        <p class="card-text text-muted small">Episodio 8 - "Susurros en la oscuridad"</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <a href="#" class="btn btn-sm btn-danger">Ver ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="https://image.tmdb.org/t/p/w500/killboy-poster-248.jpg" class="card-img-top" alt="Infierno Viviente">
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Nuevo</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">🧟‍♂️ Infierno Viviente</h5>
                        <p class="card-text text-muted small">Episodio 3 - "Noche sin escapatoria"</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <a href="#" class="btn btn-sm btn-dark">Ver ahora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>



    <?php else: ?>
    <!-- Vista para Invitados (usuarios no logueados) -->
    <div id="guestCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#guestCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        
        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://e00-elmundo.uecdn.es/assets/multimedia/imagenes/2021/05/28/16221918457790.jpg" class="d-block w-100" alt="Explora Genesia">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4 fw-bold mb-3">Explora Genesia</h1>
                    <p class="lead mb-4">Miles de películas y series en un solo lugar</p>
                    <div class="cta-buttons">
                        <a href="/suscribirse" class="btn btn-primary btn-lg px-4 me-2">Suscríbete ahora</a>
                        <a href="/explorar" class="btn btn-outline-light btn-lg px-4">Explorar contenido</a>
                    </div>
                </div>
            </div>
            
            <div class="carousel-item">
                <img src="https://risbelmagazine.es/wp-content/uploads/2025/01/estrenos-peliculas-cine-de-terror-2025.jpg"d-block w-100" alt="Acceso ilimitado">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4 fw-bold mb-3">Acceso ilimitado</h1>
                    <p class="lead mb-4">Disfruta donde quieras, cuando quieras</p>
                    <div class="cta-buttons">
                        <a href="/suscribirse" class="btn btn-primary btn-lg px-4 me-2">Suscríbete ahora</a>
                        <a href="/explorar" class="btn btn-outline-light btn-lg px-4">Explorar contenido</a>
                    </div>
                </div>
            </div>
            
            <div class="carousel-item">
                <img src="https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/media/image/2024/10/nueve-peliculas-terror-desenlace-no-podras-anticipar-4252858.jpg?tf=3840x" class="d-block w-100" alt="Contenido exclusivo">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4 fw-bold mb-3">Contenido exclusivo</h1>
                    <p class="lead mb-4">Solo en Genesia</p>
                    <div class="cta-buttons">
                        <a href="/suscribirse" class="btn btn-primary btn-lg px-4 me-2">Suscríbete ahora</a>
                        <a href="/explorar" class="btn btn-outline-light btn-lg px-4">Explorar contenido</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#guestCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#guestCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    
    <!-- Features Section -->
    <div class="container mt-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-device-tv fs-1"></i>
                    </div>
                    <h3>Multiplataforma</h3>
                    <p class="text-muted mb-0">Disfruta en cualquier dispositivo</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-download fs-1"></i>
                    </div>
                    <h3>Descargas</h3>
                    <p class="text-muted mb-0">Contenido disponible offline</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4 h-100">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-emoji-smile fs-1"></i>
                    </div>
                    <h3>Sin anuncios</h3>
                    <p class="text-muted mb-0">Experiencia sin interrupciones</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Asegúrate de incluir estas dependencias en tu layout principal -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Estilos para el carrusel */
        .carousel {
            max-height: 70vh;
            overflow: hidden;
        }
        
        .carousel-item {
            height: 70vh;
        }
        
        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }
        
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 1rem;
            padding: 2rem;
            bottom: 5rem;
        }
        
        /* Estilos para las tarjetas de características */
        .feature-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            color: #0C4B54;
        }
        
        /* Botones */
        .btn-primary {
            background-color: #0C4B54;
            border-color: #0C4B54;
        }
        
        .btn-primary:hover {
            background-color: #0A3A42;
            border-color: #0A3A42;
        }
        
        .btn-outline-light:hover {
            color: #0C4B54;
        }
    </style>
<?php endif; ?>


<style>
.hover-text-warning:hover {
    color: #E8F549 !important;
    transition: color 0.2s ease;
}
</style>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"></script>

<style>
:root {
    --primary-color: #0C4B54;
    --secondary-color: #E8F549;
    --dark-color: #1A1A2E;
    --light-color: #F8F9FA;
    --accent-color: #3A7D8C;
}

/* Dashboard Header */
.dashboard-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
    border-radius: 0 0 20px 20px;
    margin-bottom: 2rem;
}

/* Stat Cards */
.stat-card {
    color: white;
    border-radius: 10px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    height: 100%;
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 2rem;
    margin-right: 1rem;
}

.stat-content h3 {
    font-size: 1.75rem;
    margin-bottom: 0.25rem;
}

.stat-content p {
    margin-bottom: 0;
    opacity: 0.9;
}

/* Analytics Carousel */
.analytics-carousel {
    border: none;
    overflow: hidden;
}

.chart-container {
    position: relative;
    height: 350px;
    padding: 1rem;
}

.carousel-indicators button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 5px;
}

/* Content Cards */
.content-card {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.content-card:hover {
    transform: translateY(-5px);
}

.content-card .card-img {
    height: 300px;
    object-fit: cover;
}

.content-card .card-img-overlay {
    display: flex;
    justify-content: flex-end;
    padding: 1rem;
}

/* Hero Carousel */
.hero-carousel {
    height: 70vh;
    min-height: 500px;
}

.carousel-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    z-index: -1;
}

.carousel-caption {
    bottom: 10rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

/* Feature Cards */
.feature-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 2rem 0;
    }
    
    .hero-carousel {
        height: 60vh;
        min-height: 400px;
    }
    
    .carousel-caption {
        bottom: 5rem;
    }
    
    .carousel-caption h1 {
        font-size: 2rem;
    }
    
    .carousel-caption .lead {
        font-size: 1rem;
    }
    
    .cta-buttons .btn {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
}
</style>
