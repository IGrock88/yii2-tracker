<?php
/**
 * Created by PhpStorm.
 * User: igroc
 * Date: 29.08.2018
 * Time: 10:39
 */
namespace common\modules\chat\components;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use yii\helpers\StringHelper;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = [];
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients[$conn->resourceId] = [
            'conn' => $conn
        ];

        $conn->send('Вы подключены к чату');
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        if (StringHelper::startsWith($msg, \Yii::$app->params['projectToken'])){
            $idProject = str_replace(\Yii::$app->params['projectToken'], '', $msg);
            $this->clients[$from->resourceId] = [
                'idProject' => $idProject,
                'conn' => $from
            ];
            echo sprintf("\n" . '%d is connected to chat project id %d' . "\n"
                , $from->resourceId, $idProject);
        }
        else {
            $idProject = $this->clients[$from->resourceId]['idProject'];
            $this->sendMessageToUserByProject($msg, $idProject);

        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function sendMessageToUserByProject($msg, $idProject)
    {
        foreach ($this->clients as $client){
            if ($client['idProject'] == $idProject){
                $client['conn']->send($msg);
            }
        }
    }
}