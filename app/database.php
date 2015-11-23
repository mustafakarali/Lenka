<?php

if (!defined('lenka')) {
    die();
}

/* Settings to connect database */
$db = array(
  'server' => 'localhost',
  'db_name' => 'parfumal',
  'type' => 'mysql',
  'user' => 'root',
  'pass' => '26081986',
  'charset' => 'charset=utf8',
);

require_once 'core/lib/classes/Pdo.php';
$pdo = new _pdo($db);
