<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'project.title',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
                },
                'format' => 'html'
            ],
            'id',
            [
                'attribute' => 'title',
                'value' => function (\common\models\Task $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html'

            ],
            'description:ntext',
            'estimation:datetime',
            [
                'attribute' => 'executor.username',
                'value' => function (\common\models\Task $model) {
                    return !empty($model->executor) ?
                        Html::a($model->executor->username, ['user/view', 'id' => $model->executor->id]) : 'Не назначен';

                },
                'label' => 'Исполнитель',
                'format' => 'html'
            ],
            'started_at:datetime',
            'completed_at:datetime',
            //'created_by',
            //'updated_by',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{takeTask}{completeTask}{update}{delete}',
                'buttons' => [
                    'takeTask' => function ($url, \common\models\Task $model, $key) {
                        return Html::a(\yii\bootstrap\Html::icon('hand-down'), ['take', 'id' => $model->id],[
                            'data' => [
                                'confirm' => 'Действительно хотите взять задачу?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'completeTask' => function($url, \common\models\Task $model, $key){
                        return Html::a(\yii\bootstrap\Html::icon('saved'), ['complete', 'id' => $model->id],[
                            'data' => [
                                'confirm' => 'Завершить задачу?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'visibleButtons' => [
                    'update' => function (\common\models\Task $model) {
                        return Yii::$app->taskService
                            ->canManage($model->project,
                                \Yii::$app->user->identity,
                                \common\models\ProjectUser::ROLE_MANAGER);
                    },
                    'delete' => function (\common\models\Task $model) {
                        return Yii::$app->taskService
                            ->canManage($model->project,
                                \Yii::$app->user->identity,
                                \common\models\ProjectUser::ROLE_MANAGER);
                    },
                    'takeTask' => function (\common\models\Task $model) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'completeTask' => function(\common\models\Task $model){
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    }

                ]],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
