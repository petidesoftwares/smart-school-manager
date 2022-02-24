<?php


namespace Backend\Database;


use Backend\Models\Model;

class Relationship
{
    public static function belongsTo($belongsTo, $foreignKey, $primaryKey){
        ucf($belongsTo)->getTable();
    }

}