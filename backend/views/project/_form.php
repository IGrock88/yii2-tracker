<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
/* @var \common\models\User[] $userList */
?>

<div class="project-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-lg-4',
                'wrapper' => 'col-lg-6',
            ],
        ],
        'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_TEXT) ?>

    <?php if(!$model->isNewRecord){?>

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
                    'defaultValue' => $model->id
                ],
                [
                    'name' => 'user_id',
                    'title' => 'Пользователь',
                    'type' => 'dropDownList',
                    'items' => $userList
                ],
                [
                    'name' => 'role',
                    'title' => 'Роль',
                    'type' => 'dropDownList',
                    'items' => \common\models\ProjectUser::ROLES
                ]



            ]
        ]) ?>
    <?}?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
