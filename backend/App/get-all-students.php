<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;

include_once ("../../vendor/autoload.php");

if(isset($_POST)){
    $conn = new DBConnection();
    $con = $conn->connect();
    print_r($con);

//    $pupils = new AdminController();
//    echo $pupils->getAllPupils($con);
}