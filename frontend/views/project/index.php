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

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->title, ['update', 'id' => $model->id]);
                },
                'format' => 'html'
            ],
            'description:ntext',
            [
                'attribute' => \common\models\Project::RELATION_PROJECT_USERS . '.role',
                'value' => function (\common\models\Project $model) {
                    return join('; ', $model->getUserRoles(Yii::$app->user->id));
                }
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
