<?php

namespace MaterialDesignForum\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Option extends Eloquent{
  protected $table = 'option';
  protected $primaryKey = 'name';
  protected $fillable = [
    'name',
    'value',
  ];
  public $timestamps = false;
  public static function Get($name){
    $option = self::find($name);
    if($option){
      return $option->value;
    }else{
      return null;
    }
  }
}