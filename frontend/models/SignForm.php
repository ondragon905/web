<?php
namespace frontend\models;
use yii\base\Model;

class SignForm extends Model{

    public $username;
    public $password;
    public $email;

    public function rules() {
        return [
            [['username', 'password', 'email'], 'required', 'message' => 'Заполните поле'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Почта',
        ];
    }

}
?>