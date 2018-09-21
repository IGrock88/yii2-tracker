<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-lg-2 pull-right',
                'wrapper' => 'col-lg-10',
            ],
        ],
        'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-lg-2">
            <div class="panel">
                <div class="panel-body">
                    <?= Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW), ['class' => 'img-thumbnail']) ?>
                </div>
            </div>
        </div>
        <div class="panel col-lg-6 panel-primary">
            <div class="panel-body">
                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'avatar')->fileInput(['accept' => 'image/*']) ?>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>


    </div>


    <?php ActiveForm::end(); ?>

</div>
