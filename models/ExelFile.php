<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ExelFile extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    public string $path;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xls'],
        ];
    }

    public function upload(): bool
    {
        $dir = 'web/uploads/exel/';

        if ($this->validate()) {
            $this->path = $dir . Yii::$app->getSecurity()->generateRandomString(15) . '.' . $this->file->extension;
            $this->file->saveAs($this->path);

            return true;
        } else {
            return false;
        }
    }
}