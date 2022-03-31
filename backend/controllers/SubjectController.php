<?php


namespace Backend\Controllers;


use Backend\Database\DatabaseUtils;
use Backend\Models\Subject;

class SubjectController
{
    public function store($con, $data = []){
        $subject = new Subject();
        $created = $subject->create($con, $data);
        return $created;
    }

    public function getSubjectCode($con, $data=[]){
        $code = DatabaseUtils::query($con, 'SELECT code FROM subjects WHERE section =?', $data);
        return $code;
    }
}