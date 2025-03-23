<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login d-flex justify-content-center align-items-center vh-100" style="background-color: #0C4B54;">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 15px; background-color: #ffffff;">
        <div class="card-body">
            <h1 class="text-center mb-4 text-primary" style="color: #0C4B54;"> <?= Html::encode($this->title) ?> </h1>
            
            <p class="text-muted text-center">Please fill out the following fields to login:</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'needs-validation'],
                'fieldConfig' => [
                    'template' => "<div class='mb-3'>{label}{input}{error}</div>",
                    'labelOptions' => ['class' => 'form-label', 'style' => 'color: #0C4B54;'],
                    'inputOptions' => ['class' => 'form-control', 'style' => 'border-color: #0C4B54;'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Enter your username']) ?>
            
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your password']) ?>
            
            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class='form-check'>{input} {label}</div>",
                'class' => 'form-check-input',
                'labelOptions' => ['class' => 'form-check-label', 'style' => 'color: #0C4B54;'],
            ]) ?>

            <div class="d-grid">
                <?= Html::submitButton('Login', ['class' => 'btn btn-lg', 'name' => 'login-button', 'style' => 'background-color: #0C4B54; color: #ffffff; border-radius: 10px;']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="text-center text-muted mt-3">
                <small>You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.</small><br>
                <small>To modify the username/password, please check out the code <code>app\models\User::$users</code>.</small>
            </div>
        </div>
    </div>
</div>
