<?php

namespace MaterialDesignForum\Models;

//use Zhuzhichao\IpLocationZh\Ip;

use Illuminate\Database\Eloquent\Model as Eloquent;


class User extends Eloquent
{
  protected $table = 'user';
  public $timestamps = false;
  protected $primaryKey = 'user_id';
  // protected $casts = [
  //   'avatar' => 'array',//这个字段的值将会被自动转换为 PHP 数组：
  // ];
  protected $fillable = [
    'user_id', // 用户ID
    'user_group_id', // 用户组ID
    'username', // 用户名
    'email', // 邮箱
    'avatar', // 头像
    'cover', // 封面
    'password', // 密码
    'create_ip', // 创建IP
    'create_location', // 创建位置
    'last_login_time', // 最后登录时间
    'last_login_ip', // 最后登录IP
    'last_login_location', // 最后登录位置
    'follower_count', // 粉丝数
    'followee_count', // 关注数
    'following_article_count', // 关注的文章数
    'article_count', // 文章数
    'question_count', // 问题数
    'answer_count', // 回答数
    'notification_unread', // 未读通知数
    'inbox_system', // 系统消息数
    'inbox_user_group', // 用户组消息数
    'inbox_private_message', // 私信数
    'headline', // 个人简介
    'bio', // 个人介绍
    'blog', // 博客链接
    'company', // 公司
    'location', // 地址
    'create_time', // 创建时间
    'update_time', // 更新时间
    'disable_time' // 禁用时间
  ];
  public function __construct()
  {
    $this->update_time = time();
  }
  public static function GetUser($user_id)
  {
    $user = self::find($user_id);
    if ($user) {
      return $user;
    } else {
      return null;
    }
  }
  /**
   * 添加用户的关注数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddFollowerCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->follower_count += $num;
    return $user->save();
  }
  /**
   * 添加用户的粉丝数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddFolloweeCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->followee_count += $num;
    return $user->save();
  }
  /**
   * 添加用户的文章数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddArticleCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->article_count += $num;
    return $user->save();
  }
  /**
   * 添加用户的问题数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddQuestionCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->question_count += $num;
    return $user->save();
  }
  /**
   * 添加用户的回答数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddAnswerCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->answer_count += $num;
    return $user->save();
  }
  /**
   * 添加用户的未读通知数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddNotificationUnread($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->notification_unread += $num;
    return $user->save();
  }
  /**
   * 添加用户的系统消息数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddInboxSystem($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->inbox_system += $num;
    return $user->save();
  }
  /**
   * 添加用户的用户组消息数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddInboxUserGroup($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->inbox_user_group += $num;
    return $user->save();
  }
  /**
   * 添加用户的私信数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function AddInboxPrivateMessage($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->inbox_private_message += $num;
    return $user->save();
  }
  /**
   * 减少用户的关注数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubFollowerCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->follower_count -= $num;
    return $user->save();
  }
  /**
   * 减少用户的粉丝数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubFolloweeCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->followee_count -= $num;
    return $user->save();
  }
  /**
   * 减少用户的文章数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubArticleCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->article_count -= $num;
    return $user->save();
  }
  /**
   * 减少用户的问题数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubQuestionCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->question_count -= $num;
    return $user->save();
  }
  /**
   * 减少用户的回答数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubAnswerCount($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->answer_count -= $num;
    return $user->save();
  }
  /**
   * 减少用户的未读通知数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubNotificationUnread($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->notification_unread -= $num;
    return $user->save();
  }
  /**
   * 减少用户的系统消息数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubInboxSystem($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->inbox_system -= $num;
    return $user->save();
  }
  /**
   * 减少用户的用户组消息数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubInboxUserGroup($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->inbox_user_group -= $num;
    return $user->save();
  }
  /**
   * 减少用户的私信数
   * @param int $user_id 用户ID
   * @param int $num 数量
   * @return bool
   */
  public static function SubInboxPrivateMessage($user_id, $num = 1): bool
  {
    $user = self::find($user_id);
    $user->inbox_private_message -= $num;
    return $user->save();
  }

  public static function HandlePassword($password)
  {
    //return password_hash($password, PASSWORD_DEFAULT);
    return md5($password);
  }
  public static function PasswordHash($password, $hash)
  {
    return password_verify($password, $hash);
  }
  public static function AvatarStringToArray($avatar)
  {
    return json_decode($avatar, true);
  }
}
