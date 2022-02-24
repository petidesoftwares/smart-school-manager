<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\CommonController;

include_once ("../../vendor/autoload.php");
$conn = new DBConnection();
$con = $conn->connect();

$title = new CommonController();
echo ($title->getTitles($con));
