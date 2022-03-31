<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\SubjectController;

include_once ("../../vendor/autoload.php");
$conn = new DBConnection();
$con = $conn->connect();
$admin = new \Backend\Controllers\AdminController();
 echo json_decode($admin->getCurrentSession($con))[0]->session;