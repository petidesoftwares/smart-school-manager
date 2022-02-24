<?php


namespace Backend\Controllers;

use Backend\Models\Pupil;
use Backend\Models\PupilOthername;

class AdminController
{

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
        return $pupils->all($con);
    }

    public function getPupilBySection($con, $data){
        $pupils = new Pupil();
        return $pupils->allWithKey($con, $data);
    }

    public function getPupilsByClass($con, $key){
        $pupilsArray =[];
        $ids = DatabaseUtils::query($con,"SELECT id FROM registration WHERE class = ?",['class'=>$key]);
        foreach ($ids as $id){
            $pupil = new Pupil();
            $getPupil = $pupil->allWithKey($con, ['id'=>$id->id]);
            $pupilsArray[] = $getPupil;
        }
        return $pupilsArray;
    }

}