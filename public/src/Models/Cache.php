<?php namespace MaterialDesignForum\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Cache extends Eloquent{
  protected $table = 'cache';
  public $timestamps = false;
  protected $fillable = [
    'name',//名称
    'value',//值
    'create_time',//创建时间
    'life_time'//有效时间
  ];

  //protected $primaryKey = 'name';
  public static function IsVaildCaptcha($name):bool
  {
    $captcha = Cache::where('name','=', $name)->where('life_time', '>', time())->first();
    if($captcha){
      return true;
    }else{
      return false;
    }
  }
  public static function DeleteCaptcha($name)
  {
    self::where('name', '=', $name)->delete();
    self::where('life_time', '<', time())->delete();
  }
}
