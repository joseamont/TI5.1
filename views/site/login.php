<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar Sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login d-flex justify-content-center align-items-center min-vh-100" style="
    background: linear-gradient(-45deg, #0C4B54 0%, #0A3A42 50%, #082E36 100%);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
">
    <div class="card shadow-lg p-4" style="
        max-width: 420px; 
        width: 100%; 
        border-radius: 16px; 
        border: none; 
        overflow: hidden; 
        background-color: rgba(255,255,255,0.97);
        backdrop-filter: blur(8px);
        transform: translateY(0);
        transition: transform 0.5s ease, box-shadow 0.5s ease;
        animation: cardEntrance 0.8s ease-out;
    ">
        <div class="card-header bg-transparent border-0 pt-4 pb-2">
            <div class="text-center mb-4">
                <div class="login-icon-container mb-3" style="
                    animation: iconFloat 4s ease-in-out infinite;
                ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#0C4B54" class="bi bi-shield-lock" viewBox="0 0 16 16">
                        <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z"/>
                    </svg>
                </div>
                <h1 class="text-center mb-1" style="
                    color: #0C4B54; 
                    font-weight: 700; 
                    font-size: 1.8rem;
                    animation: fadeInDown 0.8s ease-out;
                "><?= Html::encode($this->title) ?></h1>
                <p class="text-center text-muted mb-0" style="
                    font-size: 0.95rem;
                    animation: fadeIn 1s ease-out 0.2s both;
                ">Accede a tu cuenta segura</p>
            </div>
        </div>
        
        <div class="card-body pt-1 pb-3">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'needs-validation', 'novalidate' => true],
                'fieldConfig' => [
                    'template' => "<div class='mb-3 position-relative'>{label}{input}{error}</div>",
                    'labelOptions' => ['class' => 'form-label', 'style' => 'color: #0C4B54; font-size: 0.95rem; font-weight: 500;'],
                    'inputOptions' => ['class' => 'form-control py-2 ps-4', 'style' => '
                        border-radius: 10px; 
                        border: 1px solid #e0e0e0; 
                        height: 48px;
                        transition: all 0.3s ease;
                    '],
                    'errorOptions' => ['class' => 'invalid-feedback', 'style' => 'font-size: 0.85rem;'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true, 
                'placeholder' => 'Ingresa tu usuario',
            ])->label('<i class="bi bi-person-fill me-2"></i>Usuario') ?>
            
            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Ingresa tu contraseña',
            ])->label('<i class="bi bi-lock-fill me-2"></i>Contraseña') ?>
            
            <div class="d-flex justify-content-between align-items-center mb-3" style="
                animation: fadeIn 1s ease-out 0.4s both;
            ">
                <?= $form->field($model, 'rememberMe', [
                    'template' => "<div class='form-check form-switch'>{input} {label}</div>",
                    'options' => ['class' => 'mb-0'],
                ])->checkbox([
                    'class' => 'form-check-input',
                    'labelOptions' => ['class' => 'form-check-label', 'style' => 'color: #6c757d; font-size: 0.9rem;'],
                ]) ?>
                
    
            </div>

            <div class="d-grid mb-3" style="
                animation: fadeIn 1s ease-out 0.5s both;
            ">
                <?= Html::submitButton('Ingresar', [
                    'class' => 'btn btn-lg py-2 fw-bold', 
                    'name' => 'login-button', 
                    'style' => '
                        background-color: #0C4B54; 
                        color: #ffffff; 
                        border-radius: 10px; 
                        border: none; 
                        letter-spacing: 0.5px; 
                        height: 48px; 
                        transition: all 0.3s;
                    '
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="text-center mt-4" style="font-size: 0.95rem;">
                <div class="position-relative my-3" style="
                    animation: fadeIn 1s ease-out 0.7s both;
                ">
                    <hr style="border-color: rgba(0,0,0,0.1);">
                    <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted" style="
                        font-size: 0.85rem;
                    ">O</span>
                </div>
                <a href="<?= \yii\helpers\Url::to(['site/google-login']) ?>">
    <button class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center" style="
        border-radius: 10px; 
        font-size: 0.95rem; 
        height: 48px; 
        transition: all 0.3s;
        animation: fadeIn 1s ease-out 0.8s both;
    ">
        <i class="bi bi-google me-2"></i>Continuar con Google
    </button>
</a>
            </div>
        </div>
        
        <div class="card-footer bg-transparent border-0 text-center pb-3 pt-2" style="
            animation: fadeIn 1s ease-out 1s both;
        ">
            <small class="text-muted" style="font-size: 0.8rem;">&copy; <?= date('Y') ?> <?= Yii::$app->name ?>. Todos los derechos reservados.</small>
        </div>
    </div>
</div>

<style>
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes cardEntrance {
        from { 
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to { 
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInDown {
        from { 
            opacity: 0;
            transform: translateY(-20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes iconFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .login-icon-container {
        background-color: rgba(12, 75, 84, 0.1);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .form-control:focus {
        border-color: #0C4B54;
        box-shadow: 0 0 0 0.25rem rgba(12, 75, 84, 0.15);
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary {
        border-color: #dee2e6;
        color: #495057;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .form-check-input:checked {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
    }
    
    .invalid-feedback {
        display: block;
    }
    
    .btn-primary:hover {
        background-color: #0A3A42 !important;
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 4px 12px rgba(12, 75, 84, 0.3);
    }
    
    a:hover {
        text-decoration: underline !important;
        transform: translateY(-1px);
    }
    
    .card:hover {
        transform: translateY(-5px) scale(1.005);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Efecto de onda al hacer clic en los botones */
    .btn:active {
        transform: scale(0.98);
    }
    
    /* Efecto de carga para el botón de submit */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(12, 75, 84, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(12, 75, 84, 0); }
        100% { box-shadow: 0 0 0 0 rgba(12, 75, 84, 0); }
    }
    
    .btn-loading {
        animation: pulse 1.5s infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Efecto de carga al enviar el formulario
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            const submitBtn = document.querySelector('[name="login-button"]');
            if (submitBtn) {
                submitBtn.classList.add('btn-loading');
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Ingresando...';
            }
        });
    }
    
    // Efecto hover mejorado para las tarjetas
    const card = document.querySelector('.card');
    if (card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.005)';
            this.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
        });
    }
    
    // Efecto ripple para los botones
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const x = e.clientX - e.target.getBoundingClientRect().left;
            const y = e.clientY - e.target.getBoundingClientRect().top;
            
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 1000);
        });
    });
});

// Agregar estilos dinámicos para el efecto ripple
const style = document.createElement('style');
style.innerHTML = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.7);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
        width: 20px;
        height: 20px;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>