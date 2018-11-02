<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \common\models\Project[] $userProjects */
/* @var array $projectDevelopers */
/* @var array $projectManagers */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if (Yii::$app->projectService->hasRolesAllProject(Yii::$app->user->identity,
        \common\models\ProjectUser::ROLE_MANAGER)) { ?>
        <p>
            <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'project_id',
                'filter' => $userProjects,
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project_id]);
                },
                'format' => 'html',
                'label' => 'Проект'
            ],
            'id',
            [
                'attribute' => 'title',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html'

            ],
            //'description:ntext',
            'estimation:datetime',
            [
                'attribute' => 'executor_id',
                'filter' => $projectDevelopers,
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->executor->username, ['user/view', 'id' => $model->executor->id]);

                },
                'label' => 'Исполнитель',
                'format' => 'html'
            ],
            'started_at:date',
            'completed_at:date',
            [
                'attribute' => 'created_by',
                'filter' => $projectManagers,
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'html',
                'label' => 'Создал задачу'
            ],
            'created_at:date',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{takeTask}{completeTask}{redoTask}{update}{delete}',
                'buttons' => [
                    'takeTask' => function ($url, \common\models\Task $model, $key) {
                        return Html::a(\yii\bootstrap\Html::icon('hand-down'), ['take', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Действительно хотите взять задачу?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'completeTask' => function ($url, \common\models\Task $model, $key) {
                        return Html::a(\yii\bootstrap\Html::icon('saved'), ['complete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Завершить задачу?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'redoTask' => function ($url, \common\models\Task $model, $key) {
                        return Html::a(\yii\bootstrap\Html::icon('repeat'), ['redo', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Отправить на доработку?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'visibleButtons' => [
                    'update' => function (\common\models\Task $model) {
                        return Yii::$app->projectService
                            ->canManage($model->project,
                                Yii::$app->user->identity);
                    },
                    'delete' => function (\common\models\Task $model) {
                        return Yii::$app->projectService
                            ->canManage($model->project,
                                Yii::$app->user->identity);
                    },
                    'takeTask' => function (\common\models\Task $model) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'completeTask' => function (\common\models\Task $model) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    },
                    'redoTask' => function (\common\models\Task $model) {

                        return Yii::$app->projectService->canManage($model->project, Yii::$app->user->identity) &&
                            Yii::$app->taskService->isComplete($model);
                    }


                ]],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
