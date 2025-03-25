<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsuarioTic $model */

$this->title = 'Create Usuario Tic';
$this->params['breadcrumbs'][] = ['label' => 'Usuario Tics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-tic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
