<?php
namespace common\modules\chat\widgets;

use Yii;


class Chat extends \yii\bootstrap\Widget
{
    public function run()
    {
        return $this->render('chat');
    }
}
