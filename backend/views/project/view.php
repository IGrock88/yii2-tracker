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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            ['attribute' => 'active',
                'value' => \common\models\Project::STATUS_TEXT[$model->active],
                'label' => 'Статус'
            ],
             [
                 'attribute' => 'creator.username',
                 'label' => 'Имя создателя',
                 'value' => Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]),
                 'format' => 'html'
            ],
            [
                'attribute' => 'updater.username',
                'label' => 'Кто обновил',
                'value' => Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]),
                'format' => 'html'
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
