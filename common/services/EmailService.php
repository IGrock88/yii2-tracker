<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 11.09.2018
 * Time: 14:19
 */

namespace common\services;


use Yii;
use yii\base\Component;

class EmailService extends Component
{
    public function send($to, $subject, $views, $update)
    {
        return Yii::$app
            ->mailer
            ->compose($views, $update)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}