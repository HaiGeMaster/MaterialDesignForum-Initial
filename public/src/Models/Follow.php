<?php

namespace MaterialDesignForum\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Follow extends Eloquent
{
  protected $table = 'follow';
  public $timestamps = false;
  protected $primaryKey = 'follow_id';
  protected $fillable = [
    'follow_id',
    'user_id',
    'followable_type',
    'followable_id',
    'create_time'
  ];
}
