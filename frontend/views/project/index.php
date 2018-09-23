<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html'
            ],
            'description:ntext',
            [
                'attribute' => 'active',
                'filter' => \common\models\Project::STATUS_TEXT,
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_TEXT[$model->active];
                }
            ],
            [
                'attribute' => \common\models\Project::RELATION_PROJECT_USERS . '.role',
                'value' => function (\common\models\Project $model) {
                    return join('; ', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'creator',
                'label' => 'Создатель',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'html'

            ],
            [
                'attribute' => 'updater',
                'label' => 'Кто обновил',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                },
                'format' => 'html'

            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'visibleButtons' => [
                    'update' => function (\common\models\Project $model) {
                        return Yii::$app->projectService->canManage($model, Yii::$app->user->identity);
                    },
                ]


            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
