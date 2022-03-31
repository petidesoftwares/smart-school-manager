<?php


namespace Backend\Models;


class TeacherOthername extends Model
{
    protected $table = "teacher_othername";
    protected $fillable = [
        'id',
        'teacher_id',
        'othername'
    ];
}