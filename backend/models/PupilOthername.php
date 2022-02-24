<?php


namespace Backend\Models;


class PupilOthername extends Model
{
    protected $table = 'pupil_othername';

    protected $fillable = [
        'id',
        'pupil_id',
        'othername'
    ];

}