<?php


namespace console\controllers;


use yii\console\Controller;



class ConsoleGreetingsController extends Controller
{
    /**
     * Output Hello, world!!!
     *
     * @param null $param
     */
    public function actionIndex($param = null)
    {
        echo 'Hello, world!!!';
    }
}
