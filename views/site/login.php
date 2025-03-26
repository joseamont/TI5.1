<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login d-flex justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg, #0C4B54 0%, #0A3A42 100%);">
    <div class="card shadow-lg p-4" style="max-width: 420px; width: 100%; border-radius: 12px; border: none; overflow: hidden;">
        <div class="card-header bg-transparent border-0 pt-4">
            <div class="text-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#0C4B54" class="bi bi-shield-lock" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                    <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z"/>
                </svg>
            </div>
            <h1 class="text-center mb-1" style="color: #0C4B54; font-weight: 600;"><?= Html::encode($this->title) ?></h1>
            <p class="text-center text-muted mb-0" style="font-size: 0.9rem;">Access your secure account</p>
        </div>
        
        <div class="card-body pt-2">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'needs-validation', 'novalidate' => true],
                'fieldConfig' => [
                    'template' => "<div class='mb-3'>{label}{input}{error}</div>",
                    'labelOptions' => ['class' => 'form-label', 'style' => 'color: #0C4B54; font-size: 0.9rem; font-weight: 500;'],
                    'inputOptions' => ['class' => 'form-control py-2', 'style' => 'border-radius: 8px; border: 1px solid #e0e0e0;'],
                    'errorOptions' => ['class' => 'invalid-feedback', 'style' => 'font-size: 0.8rem;'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true, 
                'placeholder' => 'Enter your username',
                'style' => 'padding-left: 40px;'
            ])->label('<i class="bi bi-person-fill me-2"></i>Username') ?>
            
            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Enter your password',
                'style' => 'padding-left: 40px;'
            ])->label('<i class="bi bi-lock-fill me-2"></i>Password') ?>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <?= $form->field($model, 'rememberMe', [
                    'template' => "<div class='form-check'>{input} {label}</div>",
                    'options' => ['class' => 'mb-0'],
                ])->checkbox([
                    'class' => 'form-check-input',
                    'labelOptions' => ['class' => 'form-check-label', 'style' => 'color: #6c757d; font-size: 0.85rem;'],
                ]) ?>
                
                <?= Html::a('Forgot password?', '#', ['class' => 'text-decoration-none', 'style' => 'color: #0C4B54; font-size: 0.85rem;']) ?>
            </div>

            <div class="d-grid mb-3">
                <?= Html::submitButton('Login', [
                    'class' => 'btn btn-lg py-2 fw-bold', 
                    'name' => 'login-button', 
                    'style' => 'background-color: #0C4B54; color: #ffffff; border-radius: 8px; border: none; letter-spacing: 0.5px;'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="text-center mt-4" style="font-size: 0.9rem;">
                <p class="text-muted mb-2">Don't have an account? <?= Html::a('Sign up', '#', ['style' => 'color: #0C4B54; font-weight: 500; text-decoration: none;']) ?></p>
                <div class="position-relative my-3">
                    <hr>
                    <span class="position-absolute top-50 start-50 translate-middle px-2 bg-white text-muted" style="font-size: 0.8rem;">OR</span>
                </div>
                <button class="btn btn-outline-secondary w-100 py-2" style="border-radius: 8px; font-size: 0.9rem;">
                    <i class="bi bi-google me-2"></i>Continue with Google
                </button>
            </div>
        </div>
        
        <div class="card-footer bg-transparent border-0 text-center pb-3">
            <small class="text-muted" style="font-size: 0.75rem;">&copy; <?= date('Y') ?> Your Company. All rights reserved.</small>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #0C4B54;
        box-shadow: 0 0 0 0.25rem rgba(12, 75, 84, 0.15);
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #6c757d;
    }
    
    .form-check-input:checked {
        background-color: #0C4B54;
        border-color: #0C4B54;
    }
    
    .invalid-feedback {
        display: block;
    }
</style>