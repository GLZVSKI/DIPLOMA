<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Регистрация';
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="register-form">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
