<?php

namespace common\modules\chat\controllers;

use common\modules\chat\components\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `chat` module
 */
class ServerController extends Controller
{

    public function actionIndex()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );

        echo 'chat server launch'. PHP_EOL;
        $server->run();
    }
}
