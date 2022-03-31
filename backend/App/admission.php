<?php

use Backend\Authentication\Encryptor;
use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;
use Backend\Controllers\ParentsController;
use Backend\Controllers\PupilController;
use Backend\Controllers\RegistrationController;
use Backend\Models\Parents;
use Backend\Models\Pupil;

include_once ("../../vendor/autoload.php");
    if(isset($_POST)){

        /**
         * Receive input data from frontend form
         */
        $admitted_into = strtolower($_POST['admitted_into']);
        $date_of_birth = $_POST['date_of_birth'];
        $firstname= $_POST['firstname'];
        $passpoertID = $_POST['passport_id'];
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

        $conn = new DBConnection();
        $con = $conn->connect();

        $con->begin_transaction();

        try{
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
            $admin = new AdminController();
            $createParent = $parentController->store($parentData);

            /*********Use Parent ID to create pupil ************/

            $parent = new Parents();
            $pupilData = [
                'surname' => $surname,
                'firstname' => $firstname,
                'gender' => $student_gender,
                'passport_id'=>$passpoertID,
                'date_of_birth' => $date_of_birth,
                'admitted_into' => $admitted_into,
                'parent_id'=> $parent->getLastID($con),
                'section' => $section,
                'lga_id' => $lga,
                'state_id' => $state_of_origin,
                'created_at' => date("Y-m-d h:i:sa"),
                'updated_at' => date("Y-m-d h:i:sa")
            ];

            $pupilController = new PupilController();
            $result = $pupilController->store($pupilData);

            /*********Use pupil ID to create other name***********/

            if($othername !== "" && $othername !== null){
                $pupil = new Pupil();
                $pupilOthernameArray =['pupil_id'=> $pupil->getLastID(),'othername'=>$othername];
                $createOthername = $admin->createPupilOthername($pupilOthernameArray);
            }

            /**
             * Auto register pupil at time the of admission
             */
            $subject = new SubjectController();
            $reg = new RegistrationController();
            $session = $admin->getCurrentSession($con);
            $currentSession = json_decode($session);
            $code = json_decode($subject->getSubjectCode($con,['section'=>'primary']),false);
            for($i =0; $i<count($code);$i++){
                $regData = [
                    'pupil_id' => $pupil->getLastID($con),
                    'subject_code' =>$code[$i]->code,
                    'session' => $session[0]->session,
                    'section' => $section,
                    'current_class'=>$admitted_into
                ];
                $reg->store($con, $regData);
            }
            $con->commit();
            echo "Successful: A new record has been successfully created";
        }catch (mysqli_sql_exception $exception){
            $con->rollback();
            throw $exception;
        }
    }