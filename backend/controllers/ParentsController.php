<?php


namespace Backend\Controllers;


use Backend\Models\Parents;

class ParentsController
{
    public function store($con, $data=[]){
        $parent = new Parents();
        $created = $parent->create($con, $data);
        return $created;
    }
}