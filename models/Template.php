<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "templates".
 *
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property string $date
 * @property int|null $deleted
 *
 * @property User $user
 */
class Template extends ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'path', 'date'], 'required'],
            [['user_id', 'deleted'], 'integer'],
            [['date'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['file', 'image',
                'extensions' => ['jpg', 'jpeg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 1024 * 1024 * 5,
                'tooBig' => 'Limit is 5MB'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'path' => 'Path',
            'date' => 'Date',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function upload()
    {
        $name = $this->randomFileName($this->file->extension);

        $this->path = $name;
        $this->date = date('Y-m-d H:i:s');
        $this->user_id = \Yii::$app->user->identity->id;

        if ($this->validate()) {
            $dir = 'web/uploads/templates';
            $file = $dir . $name;

            $this->file->saveAs($file);

            if ($this->save(false)) {
                return true;
            }

            return false;
        } else {
            return false;
        }
    }

    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }
}
