<?php


namespace Backend\Models;


class ParentOthername extends Model
{
    protected $table = "parent_othername";
    protected $fillable = [
        'id',
        'parent_id',
        'othername'
    ];
}