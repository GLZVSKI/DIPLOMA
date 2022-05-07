<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = 'Создание документа';
\yii\web\YiiAsset::register($this);
?>
<div class="template-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить этот шаблон?',
                'method' => 'post',
            ],
        ]) ?>
        <button class="btn btn-primary" id="btn_add_text_field">Добавить текстовое поле</button>
        <button class="btn btn-success" id="btn_save_image">Сохранить изображение</button>
    </p>


    <div class="co p-0 d-flex">
        <div id="block_image">
            <canvas id="canvas">
                <img id="image" src="<?= Yii::getAlias('@web/web/uploads/templates/') . $model->path ?>" hidden alt="image">
            </canvas>
        </div>

        <div class="col p-0">
        </div>
    </div>

</div>

<script src="<?= Yii::getAlias('@web/web') ?>/js/create_template.js"></script>