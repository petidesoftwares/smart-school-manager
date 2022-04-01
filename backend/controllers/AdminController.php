<?php


namespace Backend\Controllers;


use Backend\Database\DatabaseUtils;
use Backend\Models\Model;
use Backend\Models\Pupil;
use Backend\Models\PupilOthername;
use Backend\Models\Subject;
use Backend\Models\Teacher;
use Backend\Models\TeacherOthername;

class AdminController
{
    public function __construct(){
        
    }
    /**
     * Store pupil record to database
     * @param array $data : Array of pupil record
     * @return bool|string|void : Response to storage
     */
    public function createPupilOthername($con,$data=[]){
        $pupilOthername = new PupilOthername();
        return $pupilOthername->create($con, $data);
    }

    public function getAllPupils($con){
        $pupils = new Pupil();
        $othername = new PupilOthername();
        return $pupils->allWithRelationship($con,$othername->getTable());
    }

    public function getPupilBySection($con, $data){
        $pupils = new Pupil();
        $othernames = new PupilOthername();
        return $pupils->getAllWithRelationshipAndConstraints($con,$othernames->getTable(), $data);
    }

    public function getPupilsByClass($con, $key){
        $pupilsArray =[];
        $ids = DatabaseUtils::query($con,"SELECT id FROM registration WHERE class = ?",['class'=>$key]);
        foreach ($ids as $id){
            $pupil = new Pupil();
            $othername = new PupilOthername();
            $getPupil = $pupil->getAllWithRelationshipAndConstraints($con, $othername->getTable(), ['id'=>$id->id]);
            $pupilsArray[] = $getPupil;
        }
        return $pupilsArray;
    }

    public function getCurrentSession($con){
        $session = DatabaseUtils::queryDirect($con, "SELECT session FROM academic_session ORDER BY session DESC LIMIT 1");
        return $session;
    }

    public function createTeacher($con, $data = []){
        $teacher = new Teacher();
        return $teacher->create($con, $data);
    }

    public function createTeacherOtherName($con, $data =[]){
        $teacher = new TeacherOthername();
        return $teacher->create($con, $data);
    }

    public function getTeachersFullName($con){
        $teacher = new Teacher();
        $othername = new TeacherOthername();
        return $teacher->allWithRelationship($con,$othername->getTable());
    }

    public function getSubjects($con){
        $subject = new Subject();
        return $subject->all($con);
    }
}