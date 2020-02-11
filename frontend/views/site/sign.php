<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>
<div class="form-group">
    <div>
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>