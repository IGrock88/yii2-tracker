<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */



$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['chat']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <?= \common\modules\chat\widgets\Chat::widget(['port' => 8080]);?>

</div>
