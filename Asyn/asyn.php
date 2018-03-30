<?php

$server = new swoole_server("127.0.0.1", 9501);

//$server->on('connect', function ($serv, $fd) {
//    echo "Client: Connect.\n";
//});

$server->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server:".$data);
});

//$server->on('close', function ($serv, $fd) {
//    echo "Client: Close.\n";
//});

//处理异步任务
$server->on('task', function ($serv, $task_id, $from_id, $data) {
    echo "New AsyncTask[id=$task_id]".PHP_EOL;
    //返回任务执行的结果
    $serv->finish("$data -> OK");
});

//处理异步任务的结果
$server->on('finish', function ($serv, $task_id, $data) {
    echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
});

$server->start();