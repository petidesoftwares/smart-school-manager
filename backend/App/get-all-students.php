<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;
use Backend\Models\Model;
use Backend\Models\Pupil;
use Backend\Models\PupilOthername;

include_once ("../../vendor/autoload.php");

if(isset($_POST)){
    $conn = new DBConnection();
    $con = $conn->connect();

//    $pupils = new AdminController();
//    echo $pupils->getAllPupils($con);

    $pupils = new Pupil();
    $othername = new PupilOthername();
    echo $pupils->allWithRelationship($con,$othername->getTable());
}