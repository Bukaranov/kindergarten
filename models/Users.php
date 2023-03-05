<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string $full_name
 * @property string $login
 * @property string $password
 * @property string $role
 *
 * @property Requests[] $requests
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ADMIN = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public $roleArr = [
        1 => 'Адміністратор',
        2 => 'Батьки',
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'password', 'role'], 'required'],
            [['role'], 'integer'],
            [['full_name'], 'string', 'max' => 255],
            [['login', 'password'], 'string', 'max' => 45],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID користувача',
            'full_name' => 'Повне ім\'я',
            'login' => 'Логін',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['user_id' => 'user_id']);
    }


    public static function findIdentity($id)
    {
        return Users::findOne($id);
    }

    public function getId()
    {
        return $this->user_id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }


    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByLogin($email)
    {
        return Users::find()->where(['login'=>$email])->one();
    }

    public function validatePassword($password)
    {
        if ($this->password == $password){
            return true;
        }
        return false;
    }

    public function getRoleName()
    {
        return $this->roleArr[$this->role];
    }

    public function getIsAdmin()
    {
        return $this->role == self::ADMIN;
    }

}
