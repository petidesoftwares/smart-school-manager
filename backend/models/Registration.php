<?php


namespace Backend\Models;


class Registration extends Model
{
    protected $primaryKey = 'pupil_id, subject_code,session, section';
    protected $fillable =[
        'pupil_id',
        'subject_code',
        'session',
        'section',
        'current_class',
        'term',
        'ca',
        'score',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}