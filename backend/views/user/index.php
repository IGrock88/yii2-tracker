<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'avatar',
                'value' => function(\common\models\User $userModel){
                    $imageUrl = $userModel->getThumbUploadUrl('avatar', \common\models\User::AVATAR_ICON);
                    return $imageUrl ? $imageUrl : '';
                },
                'format' => 'image',
                'contentOptions' => ['style'=>'text-align: center;vertical-align: middle;']
            ],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => \common\models\User::STATUS_TEXT,
                'value' => function(\common\models\User $userModel){
                    return \common\models\User::STATUS_TEXT[$userModel->status];
                }
            ],

            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
