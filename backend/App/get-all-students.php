<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;

include_once ("../vendor/autoload.php");

if(isset($_POST)){
    $conn = new DBConnection();
    $con = $conn->connect();

    $pupils = new AdminController();
    echo $pupils->getAllPupils($con);
}