<?php 

class Client
{
    private $client;

    public function __construct()
    {
        // $this->client = new swoole_client(SWOOLE_SOCK_TCP);
        $this->client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

        $this->client->on('Connect', array($this, 'onConnect'));
        $this->client->on('Receive', array($this, 'onReceive'));
        $this->client->on('Close', array($this, 'onClose'));
        $this->client->on('Error', array($this, 'onError'));
    }

    public function connect()
    {
        if (!$this->client->connect("127.0.0.1", 9501, 1)) {
            echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
        }

        // $message = $this->client->recv();
        // echo "Get Message From Server {$message}\n";

        // fwrite(STDOUT, "请输入消息:");
        // $msg = trim(fgets(STDIN));
        // $this->client->send($msg);
    }

    public function onConnect($client)
    {
        fwrite(STDOUT, "Enter Msg:");
        swoole_event_add(STDIN, function($fp){
            global $client;
            fwrite(STDOUT, "Enter Msg:");
            $msg = trim(fgets(STDIN));
            $client->send($msg);
        });
    }

    public function onReceive($client, $data)
    {
        echo "Get Message From Server: {$data}\n";
    }

    public function onClose($client)
    {
        echo "Client close Connection\n";
    }

    public function onError()
    {

    }

    public function send($data)
    {
        $this->client->send($data);
    }

    public function isConnected()
    {
        return $this->client->isConnected();
    }
}

$client = new Client();
$client->connect();