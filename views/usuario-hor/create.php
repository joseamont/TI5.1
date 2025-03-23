<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsuarioHor $model */

$this->title = 'Create Usuario Hor';
$this->params['breadcrumbs'][] = ['label' => 'Usuario Hors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-hor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
