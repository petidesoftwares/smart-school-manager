<?php


namespace Backend\Models;


class SubjectTeacher extends Model
{
    protected $table = "subject_teacher";
    protected $fillable =[
        'id',
        'subject_code',
        'teacher_id',
        'session',
        'section'
    ];
}