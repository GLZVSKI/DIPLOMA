<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $email
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'name', 'email'], 'required'],
            [['login', 'password', 'name', 'email'], 'string', 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'name' => 'Имя',
            'email' => 'Email',
        ];
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return true;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findByUsername($login)
    {
        return self::findOne(['login' => $login]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
}
