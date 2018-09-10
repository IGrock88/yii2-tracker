<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_TEXT) ?>

    <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)
        ->widget(unclead\multipleinput\MultipleInput::class, [
            'id'=> 'project_users_widget',
            'max'               => 10,
            'min'               => 0, // should be at least 2 rows
            'allowEmptyList'    => false,
            'enableGuessTitle'  => true,
            'addButtonPosition' => MultipleInput::POS_HEADER,
            'columns' => [
                [
                    'name' => 'project_id',
                    'type' => 'hiddenInput',
                    'value' => $model->id
                ],
                [
                    'name' => 'user_id',
                    'title' => 'Пользователь',
                    'type' => 'dropDownList',
                    'items' => \common\models\User::find()->select('username')->indexBy('id')->column()
                ]



            ]
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
