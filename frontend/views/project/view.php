<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->projectService->hasRole($model, \Yii::$app->user->identity,
        \common\models\ProjectUser::ROLE_MANAGER)){?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php }?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'creator.username',
                'value' => Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]),
                'format' => 'html',
                'label' => 'Имя создателя'
            ],
            [
                'attribute' => 'updater.username',
                'value' => Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]),
                'format' => 'html',
                'label' => 'Кто обновил'
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
