<?php


namespace Backend\Models;


class Subject extends Model
{
    protected $fillable = [
        'id',
        'code',
        'title',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}