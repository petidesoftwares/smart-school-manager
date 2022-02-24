<?php

use Backend\Authentication\Encryptor;
use Backend\Controllers\AdminController;
use Backend\Controllers\ParentsController;
use Backend\Controllers\PupilController;
use Backend\Models\Parents;
use Backend\Models\Pupil;

include_once ("../../vendor/autoload.php");
    if(isset($_POST)){
        $admitted_into = $_POST['admitted_into'];
        $date_of_birth = $_POST['date_of_birth'];
        $firstname= $_POST['firstname'];
        $lga = $_POST['lga'];
        $othername= $_POST['othername'];
        $parent_email= $_POST['parent_email'];
        $parent_firstname= $_POST['parent_firstname'];
        $parent_occupation= $_POST['parent_occupation'];
        $parent_othername = $_POST['parent_othername'];
        $parent_phone  = $_POST['parent_phone'];
        $parent_surname = $_POST['parent_surname'];
        $parent_title = $_POST['parent_title'];
        $parent_gender = $_POST['parent_gender'];
        $section = $_POST['section'];
        $state_of_origin = $_POST['state_of_origin'];
        $student_gender = $_POST['student_gender'];
        $surname = $_POST['surname'];

        /************ Create Parent *****************/

        $parentData = [
            'title'=>$parent_title,
            'email' => $parent_email,
            'firstname' => $parent_firstname,
            'surname' => $parent_surname,
            'mobile_number' => $parent_phone,
            'gender' => $parent_gender,
            'password' => hash(Encryptor::ALGORITHM,$parent_phone),
            'occupation' => $parent_occupation,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        ];

        $parentController = new ParentsController();
        $createParent = $parentController->store($parentData);
        if($createParent === "successful"){
            $parent = new Parents();
            $pupilData = [
                'surname' => $surname,
                'firstname' => $firstname,
                'gender' => $student_gender,
                'date_of_birth' => $date_of_birth,
                'admitted_into' => $admitted_into,
                'parent_id'=> $parent->getLastID(),
                'section' => $section,
                'lga_id' => $lga,
                'state_id' => $state_of_origin,
                'created_at' => date("Y-m-d h:i:sa"),
                'updated_at' => date("Y-m-d h:i:sa")
            ];

            $pupilController = new PupilController();
            $result = $pupilController->store($pupilData);
            if($result === 'successful'){
                if($othername !== "" && $othername !== null){
                    $pupil = new Pupil();
                    $pupilOthernameArray =['pupil_id'=> $pupil->getLastID(),'othername'=>$othername];
                    $pupilOthername = new AdminController();
                    $createOthername = $pupilOthername->createPupilOthername($pupilOthernameArray);
                }else{
                    echo $result;
                }
                echo "Successful: A new record has been successfully created";
            }else{
                echo "Error! An error occurred while creating record. Please try again later". $result;
            }
        }else{
            echo "Error! An error occurred while creating record. Please try again later". $createParent;
        }
    }