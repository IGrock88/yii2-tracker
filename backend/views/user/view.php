<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii2mod\comments\widgets\Comment;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($model->username) ?></h1>

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
            [
                'attribute' => 'avatar',
                'value' => $model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW),
                'format' => 'image'
            ],
            'username',
            'email:email',
            ['attribute' => 'status',
                'value' => \common\models\User::STATUS_TEXT[$model->status]
                ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]);?>


    <?php echo Comment::widget([
        'model' => $model,
    ]); ?>

</div>
