<?php


namespace Backend\Controllers;


use Backend\Models\Lga;
use Backend\Models\State;
use Backend\Models\Title;

class CommonController
{
    public function getTitles($con){
        $titles = new Title();
        return $titles->all($con);
    }

    public function getStates($con){
        $states = new State();
        return $states->all($con);
    }

    public function getLGAs($con, $dataArray){
        $lga = new Lga();
        return $lga->allWithKey($con, $dataArray);
    }
}