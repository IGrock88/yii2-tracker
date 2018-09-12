<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 11.09.2018
 * Time: 14:19
 */

namespace common\services;


use common\models\User;
use Yii;
use yii\base\Component;

class EmailService extends Component
{
    /**
     * @param $subject
     * @param $views
     * @param $data
     * @return bool
     */
    public function send($subject, $views, $data)
    {
        return Yii::$app
            ->mailer
            ->compose($views, $data)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($data['user']->email)
            ->setSubject($subject)
            ->send();
    }
}