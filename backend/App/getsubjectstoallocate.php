<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;

include_once ("../../vendor/autoload.php");
$conn = new DBConnection();
$con = $conn->connect();

$admin = new AdminController();
echo $admin->getSubjects($con);