<?php 

namespace MaterialDesignForum\Config;

use MaterialDesignForum\Models\Option;

class Config{
  public static $sql_is_connect = false;
  public static function getConfig(){
    $config['webVersion'] = '1.0.0';
    $config['webDev'] = true;//false;//
    
    $config['mysqlHostname'] = 'localhost';
    $config['mysqlUsername'] = 'root';//数据库用户名
    $config['mysqlPassword'] = '003519';//数据库密码
    $config['mysqlDatabase'] = 'demo';//'root';//数据库名
    //$config['mysqlPrefix'] = '';//数据库表前缀
    if(self::$sql_is_connect){
      $config['site_name'] = Option::Get('site_name');
      $config['default_language'] = Option::Get('default_language');
      $config['smtp_username'] = Option::Get('smtp_username');//邮箱用户名(默认为QQ邮箱
      $config['smtp_password'] = Option::Get('smtp_password');//邮箱密码(默认为QQ邮箱
      $config['smtp_send_name'] = Option::Get('smtp_send_name');//发件人名称(默认为QQ邮箱
      $config['smtp_host'] = Option::Get('smtp_host');//邮箱服务器地址(默认为QQ邮箱
      $config['smtp_port'] = Option::Get('smtp_port');//邮箱服务器端口(默认为QQ邮箱
    }else{
      //self::InitConnect();
    }
    
    $config['mysqlMaxItemQueryCount'] = 20;//最大每次查询数据库的数量（条）
    return $config;
  }
  public static function Dev(){
    return self::getConfig()['webDev'];
  }
  public static function GetWebTitleName($v){
    return $v . ' - ' . self::getConfig()['site_name'];
  }
  // private static function InitConnect(){

  // }
}
