<?php


namespace Backend\Controllers;


use Backend\Models\Pupil;

class PupilController
{
    public function __construct(){
    }

    public function store($data =[]){
    $pupil = new Pupil();
    return $pupil->create($data);
    }
}