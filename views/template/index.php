<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $data yii\data\ActiveDataProvider */

$this->title = 'Мои шаблоны';
?>
<div class="template-index">

    <h1 class="mx-3"><?= Html::encode($this->title) ?></h1>

    <p class="mx-3">
        <?= Html::a('Добавить новый', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="album">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php foreach ($data as $item) { ?>
                    <div class="col my-2">
                        <div class="card shadow-sm">
                            <img src="<?= Yii::getAlias('@web/web')?>/uploads/templates/<?= $item['path'] ?>"
                                 class="bd-placeholder-img card-img-top"/>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="<?= Url::toRoute(['/template/view', 'id' => $item['id'] ])?> " class="btn btn-sm btn-outline-primary">Использовать</a>
                                        <a href="<?= Url::toRoute(['/template/delete', 'id' => $item['id'] ])?> " class="btn btn-sm btn-outline-danger">Удалить</a>
                                    </div>
                                    <small class="text-muted"><?= Yii::$app->formatter->asDate($item['date'], 'long') ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>


</div>
