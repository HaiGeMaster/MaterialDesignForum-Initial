<?php

namespace MaterialDesignForum\Collectors\Api;

use MaterialDesignForum\Models\Token as TokenModel;
use MaterialDesignForum\Models\User as UserModel;
use MaterialDesignForum\Collectors\Api\UserGroup as UserGroupCollector;

class Token extends TokenModel
{
  /**
   * 通过token获取用户ID 经过验证 
   * @param string $token token字符串
   * @return int|null 用户ID 从Token表中获取user_id 之后可做其它比较
   */
  public static function GetUserId($token)
  {
    $Server_token = self::where('token', '=', $token)
      ->where('expire_time', '>', time())
      ->first();
    $Client_user = null;
    $Client_token = '';
    $Client_device = $_SERVER['HTTP_USER_AGENT'];
    if ($Server_token) {
      $Client_user = UserModel::where('user_id', '=', $Server_token->user_id)->first();
      $Client_token = md5($Client_user->email . $Client_user->password . $Client_device);
      if ($Client_token != $token) {
        return null;
      }
      if ($Server_token->device != $Client_device) {
        return null;
      }
      if ($Server_token->token != $Client_token) {
        return null;
      }
      if($Server_token->disable_time != 0){//如果禁用时间不为0
        return null;
      }
      if(UserGroupCollector::find($Client_user->user_group_id)->ability_normal_login == false){//如果用户组不允许前台登录
        return null;
      }
      return $Server_token->user_id;
    } else {
      return null;
    }
  }
  /**
   * 通过token获取用户信息 经过验证
   * @param string $token token字符串
   * @return UserModel|null 用户信息
   */
  public static function GetUser($token)
  {
    $user_id = self::GetUserId($token);
    if ($user_id) {
      $user = UserModel::where('user_id', '=', $user_id)->first();
      if($user){
        return $user;
      }else{
        return null;
      }
    } else {
      return null;
    }
  }
  /**
   * 验证token是否是用户自己的 仅适用于用户
   * @param string $token token字符串
   * @param int $user_id 要与其对比验证的用户ID
   * @return bool $token->user_id == $target_user_id
   */
  public static function IsUserSelf($token, $target_user_id = null): bool
  {
    $Server_token_user_id = self::GetUserId($token);
    if ($Server_token_user_id == $target_user_id) {
      return true;
    } else {
      return false;
    }
  }
}
