<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Список задач';

if (Yii::$app->user->isGuest){
    echo "<br><br><br>";
    echo "<center> <h1> Пожалуйста авторизуйтесь! </h1></center>";
}
else{
    echo "<center> <h3>Список задач</h3></center>";
    include "spisok.php";
}
