<?php


namespace Backend\Models;


class Parents extends Model
{
protected $table = 'parents';
protected $fillable = [
      'id',
      'title',
      'surname',
      'firstname',
      'gender',
      'address',
      'mobile_number',
      'email',
      'password',
      'occupation',
      'created_at',
      'deleted_at',
      'updated_at'
];

}