<?php namespace MaterialDesignForum\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Token extends Eloquent{
  protected $table = 'token';
  public $timestamps = false;
  protected $fillable = [
    'token',//token 字符串
    'user_id',//用户ID
    'device',//登陆设备，浏览器 UA 等信息
    'create_time',//创建时间
    'update_time',//更新时间
    'expire_time'//过期时间
  ];
}
