<?php

require_once "vendor/autoload.php";

use Orm\Helpers\Config;

// $result  = Config::getFileContents("database");

// var_dump($result);


var_dump(Config::get("database", "pdo")); // Ok ... 


