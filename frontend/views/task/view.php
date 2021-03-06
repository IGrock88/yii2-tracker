<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->projectService->canManage($model->project, \Yii::$app->user->identity)) { ?>
        <p>
            <?php if (Yii::$app->taskService->isComplete($model)) { ?>
                <?= Html::a('Redo', ['redo', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Отправить задачу на доработку?',
                            'method' => 'post',
                        ]
                    ]) ?>
            <?php } ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>

        </p>
    <?php } ?>

    <?php if (Yii::$app->taskService->canTake($model, \Yii::$app->user->identity)) { ?>
        <p>
            <?= Html::a('Take', ['take', 'id' => $model->id],
                [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => 'Действительно хотите взять задачу?',
                        'method' => 'post',
                    ]
                ]) ?>
        </p>
    <?php } ?>

    <?php if (Yii::$app->taskService->canComplete($model, \Yii::$app->user->identity,
        \common\models\ProjectUser::ROLE_DEVELOPER)) { ?>
        <p>
            <?= Html::a('Complete', ['complete', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Действительно хотите завершить задачу?',
                        'method' => 'post',
                    ]
                ]) ?>
        </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'project.title',
                'value' => Html::a($model->project->title, ['project/view', 'id' => $model->project->id]),
                'format' => 'html'
            ],
            'id',
            'title',
            'description:ntext',
            'estimation:datetime',
            [
                'attribute' => 'executor.name',
                'value' => Html::a($model->executor->username, ['user/view', 'id' => $model->executor->id]),
                'format' => 'html'
            ],
            [
                'attribute' => 'rating',
                'value' => StarRating::widget([
                    'name' => 'task-rating',
                    'value' => $model->rating,
                    'pluginOptions' => [
                        'readonly' => true,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ]),
                'format' => 'raw',
                'label' => 'Оценка менеджера проекта'

            ],
            'started_at:datetime',
            'completed_at:datetime',
            [
                    'attribute' => 'creator.username',
                'value' => Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]),
                'format' => 'html',
                'label' => 'Создатель задачи'
            ],
            [
                'attribute' => 'updater.username',
                'value' => Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]),
                'format' => 'html',
                'label' => 'Кто обновлял'
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
