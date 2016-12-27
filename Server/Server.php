<?php

class Server
{
    private $server;

    public function __construct()
    {
        $this->server = new swoole_server("0.0.0.0", 9501);
        $this->server->set(array(
            'work_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode' => 1,
            // 'task_worker_num' => 8
        ));

        $this->server->on('Start', array($this, 'onStart'));
        $this->server->on('Connect', array($this, 'onConnect'));
        $this->server->on('Receive', array($this, 'onReceive'));
        $this->server->on('Close', array($this, 'onClose'));

        // $this->server->on('Task', array($this, 'onTask'));
        // $this->server->on('Finish', array($this, 'onFinish'));

        $this->server->start();
    }

    public function onStart($server)
    {
        echo "Start\n";
    }

    public function onConnect($server, $client, $from_id)
    {
        $server->send($client, "Welcome {$client}!");
    }

    public function onReceive(swoole_server $server, $client, $from_id, $data)
    {
        echo "Get Message From Client {$client}:{$data}\n";

        // $param = array(
        //     'client' => $client
        // );
        // //开启一个Task
        // $server->task(json_encode($param));

        echo "Continue Handle Worker\n";
    }

    public function onClose($server, $client, $from_id)
    {
        echo "Client {$client} close connection\n";
    }

    // public function onTask($server, $task_id, $from_id, $data)
    // {
    //     echo "This Task {$task_id} from Worker {$from_id}\n";
    //     echo "Data: {$data}\n";
    //     for($i = 0 ; $i < 10 ; $i ++ ) {
    //         sleep(1);
    //         echo "Taks {$task_id} Handle {$i} times...\n";
    //     }
    //     $client = json_decode($data, true)['client'];
    //     $server->send( 1, "Data in Task {$task_id}");
    //     return "Task {$task_id}'s result";
    // }

    // public function onFinish($server, $task_id, $data)
    // {
    //     echo "Task {$task_id} finish\n";
    //     echo "Result: {$data}\n";
    // }

}

$server = new Server();