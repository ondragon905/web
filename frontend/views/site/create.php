<?php
use yii\helpers\html;
use common\models\Posts;
use yii\widgets\ActiveForm;
?>
<div></div>
<center> <h1> Добавление задачи</h1> </center>
<div class = "body-content">
    <?php
        $form = \yii\widgets\ActiveForm::begin() ?>

    <div class = "row">
        <div class = "form-group">
            <div class = "col-lg-6">
                <?= $form->field($post, 'title') -> textarea(['rows' => '2']);?>
            </div>
        </div>
    </div>

    <div class = "row">
        <div class = "form-group">
            <div class = "col-lg-6">
                <div class = "col-lg-3">
                    <?= Html::submitButton('Добавить',  ['class' => 'btn btn-success'])?>
                </div>

                <div class = "col-lg-2">
                    <?= Html::a('Назад', ['/site/contact'],  ['class' => 'btn btn-success'])?>
                </div>
            </div>
        </div>
    </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
