<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//events
\yii\base\Event::on(\common\services\ProjectService::class,
    \common\services\ProjectService::EVENT_ASSIGN_ROLE,
    function (\common\services\events\AssignRole $event){
        Yii::$app->notificationService->sendChangeRoleEmail($event->getUser(), $event->getProject(), $event->getRole());
    });