<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $full_name;
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['full_name', 'login', 'password'], 'required'],
            [['full_name'], 'string'],
            [['login'], 'email'],
            [['login'], 'unique', 'targetClass'=>'app\models\Users', 'targetAttribute'=>'login'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'full_name' => 'Повне ім\'я',
            'login' => 'Логін',
            'password' => 'Пароль',
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new Users;
            $user->attributes = $this->attributes;
            $user->role = 2;
            return $user->save();
        }
    }


}