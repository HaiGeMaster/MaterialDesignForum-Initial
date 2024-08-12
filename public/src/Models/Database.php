<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use MaterialDesignForum\Config\Config;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => Config::getConfig()['mysqlHostname'],
    'database' => Config::getConfig()['mysqlDatabase'],
    'username' => Config::getConfig()['mysqlUsername'],
    'password' => Config::getConfig()['mysqlPassword'],
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix' => Config::getConfig()['mysqlPrefix'],
]);

$capsule->bootEloquent();

//如果$capsule连接成功，那么就将Config::$sql_is_connect设置为true
Config::$sql_is_connect = true;