<?php


namespace Backend\Models;


class Pupil extends Model
{
    protected $fillable =[
        'surname',
        'firstname',
        'admitted_into',
        'gender',
        'passport_id',
        'parent_id',
        'date_of_birth',
        'section',
        'state_id',
        'lga_id',
        'award',
        'created_at',
        'deleted_at',
        'updated_at'
    ];

}