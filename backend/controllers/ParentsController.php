<?php


namespace Backend\Controllers;


use Backend\Models\Parents;

class ParentsController
{
    public function store($data=[]){
        $parent = new Parents();
        $created = $parent->create($data);
        return $created;
    }
}