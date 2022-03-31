<?php

use Backend\Connection\DBConnection;
use Backend\Controllers\SubjectController;

include_once ("../../vendor/autoload.php");
    if(isset($_POST)){
        $subjects = json_decode($_POST['subjects']);
        $conn = new DBConnection();
        $con = $conn->connect();
        $subject = new SubjectController();
        $flag = false;
        $response = "";
        $dataArray = [];
        for ($i = 0; $i <count($subjects); $i++){
            $data = [];
            $data['title'] = $subjects[$i][0];
            $data['code'] = $subjects[$i][1];
            $data['section'] = $subjects[$i][2];
            $response = $subject->store($con, $data);
            if($response === 'successful'){
                $flag = true;
            }else{
                $flag = false;
                break;
            }
        }

        if ($flag == true){
            echo 'success';
        }else
            echo "Error!".$response;
    }