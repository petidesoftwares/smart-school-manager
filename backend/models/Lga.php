<?php


namespace Backend\Models;


class Lga extends Model
{
    protected $table = 'lga';
    protected $primaryKey = 'lga, state_id';

    protected $fillable = [
      'id',
      'state_id',
      'lga'
    ];

}