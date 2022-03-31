<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;

include_once ("../../vendor/autoload.php");

if(isset($_POST)){
    $pupilClass = $_POST['pupilClass'];
    $conn = new DBConnection();
    $con = $conn->connect();

    $admin = new AdminController();
    echo $admin->getPupilsByClass($con,$pupilClass);
}
