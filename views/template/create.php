<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = 'Добавить шаблон';
?>
<div class="template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
