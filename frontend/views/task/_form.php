<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var \common\models\Project[] $projects*/
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<!--    http://demos.krajee.com/datecontrol-->
    <?= $form->field($model, 'estimation')->textInput()->widget(\kartik\datecontrol\DateControl::class, [
        'options' => ['placeholder' => 'Сделать до'],
        'convertFormat' => true,
        'type' => \kartik\datecontrol\Module::FORMAT_DATETIME,
    ]) ?>

    <?= $form->field($model, 'project_id')->dropDownList($projects)->label('Проект') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
