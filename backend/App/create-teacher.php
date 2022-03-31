<?php

use Backend\Authentication\Encryptor;
use Backend\Connection\DBConnection;
use Backend\Controllers\AdminController;
use Backend\Models\Teacher;

include_once ("../../vendor/autoload.php");

    if(isset($_POST)){
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $othername =$_POST['othername'];
        $gender = $_POST['gender'];
        $phoneNumber = $_POST['phoneNumber'];
        $email = $_POST['email'];
        $employmentType = $_POST['employmentType'];
        $teachingType = $_POST['teachingType'];

            $teacherDataArray = [
                'title' => $title,
                'firstname' => $firstname,
                'surname' => $surname,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'password' => hash(Encryptor::ALGORITHM, $phoneNumber),
                'gender' => $gender,
                'employment_type' => $employmentType,
                'teaching_type' => $teachingType,
                'created_at' => date("Y-m-d h:i:sa"),
                'updated_at' => date("Y-m-d h:i:sa")
            ];

        $conn = new DBConnection();
        $con = $conn->connect();

        $admin = new AdminController();
        $con->begin_transaction();

        try {
            $admin->createTeacher($con, $teacherDataArray);
            if($othername != "" && $othername != null){
                $teacher = new Teacher();
                $otherNameData = [
                    'teacher_id'=>$teacher->getLastID($con),
                    'othername' => $othername
                ];
                $admin->createTeacherOtherName($con, $otherNameData);
            }

            $con->commit();

            echo "Teacher ". $title." ". $firstname. " ".$surname." successfully created.";
        }catch (mysqli_sql_exception $exception){
            $con->rollback();
            echo $exception;
        }
    }