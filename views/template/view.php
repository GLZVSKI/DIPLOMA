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
        <button class="btn btn-primary" id="btn_add_text_field">Вставить текст</button>
    </p>


    <div class="co p-0 pb-5 d-flex">
        <div id="block_image">
            <canvas id="canvas">
                <img id="image" src="<?= Yii::getAlias('@web/web/uploads/templates/') . $model->path ?>" hidden alt="image">
            </canvas>
            <button class="btn btn-success mb-5" id="btn_save_image">Сохранить изображение</button>
        </div>

        <div class="col p-0">
            <div class="col">
                <h2>Вставка данных из Exel-файла</h2>
                <div class="mb-3">
                    <input class="form-control" type="file" id="field_exel_file">
                    <button type="submit" class="btn btn-primary mt-2" id="btn_exel_file" disabled>Получить данные</button>
                </div>

                <div class="col m-0 p-0 mb-4" hidden>
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                    </svg>

                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                        <div class="ml-2">
                            Нажмите кнопку разместить, чтобы
                            выбрать место размещения данных из таблицы.
                        </div>
                    </div>
                    <ul class="list-group" id="list_fields"></ul>

                    <button type="submit" class="btn btn-success mt-2" id="btn_enter_data" disabled>Вставить данные</button>
                </div>

                <h4>Предпросмотр данных таблицы:</h4>
                <table id="table" class="table table-striped"></table>
            </div>
        </div>
    </div>

</div>

<script src="<?= Yii::getAlias('@web/web') ?>/js/create_template.js"></script>