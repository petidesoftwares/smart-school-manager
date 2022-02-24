<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\CommonController;

include_once ("../../vendor/autoload.php");
    if(isset($_POST)){
        $conn = new DBConnection();
        $con = $conn->connect();

        $state_id = $_POST['state_id'];
        $inputArray = ['state_id'=>(int)$state_id];
        $lgas = new CommonController();
        echo $lgas->getLGAs($con, $inputArray);
    }