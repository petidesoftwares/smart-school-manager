<?php


namespace Backend\Models;


class Teacher extends Model
{
    protected $fillable = [
        'id',
        'title',
        'firstname',
        'surname',
        'phone_number',
        'email',
        'password',
        'gender',
        'd_o_b',
        'qualification',
        'grade',
        'employment_type',
        'teaching_type',
        'state_id',
        'lga_id',
        'employment_status',
        'address',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}