<?php


namespace Backend\Controllers;


use Backend\Models\Registration;

class RegistrationController
{
    public function store($con, $data = []){
        $register = new Registration();
        return $register->create($con, $data);

    }
}