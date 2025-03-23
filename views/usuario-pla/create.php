<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsuarioPla $model */

$this->title = 'Create Usuario Pla';
$this->params['breadcrumbs'][] = ['label' => 'Usuario Plas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-pla-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
