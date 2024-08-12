<?php

namespace MaterialDesignForum\Collectors\Api;

use MaterialDesignForum\Models\UserGroup as UserGroupModel;
use MaterialDesignForum\Collectors\Api\Token as TokenCollector;

class UserGroup extends UserGroupModel
{
  /**
   * 验证token是否是管理员
   * @param string $token token字符串
   * @return bool $user_group->ability_admin_login
   */
  public static function IsAdmin($token):bool
  {
    return self::Ability($token,'ability_admin_login');
  }
  /**
   * 获取用户token所在的用户组
   * @param string $token token字符串
   * @return UserGroup|null 用户组
   */
  public static function GetUserLocationGroup($token)
  {
    $user_group_id = TokenCollector::GetUser($token)->user_group_id;
    if($user_group_id!=null){
      $user_group = self::where('user_group_id', '=', $user_group_id)->first();
      if($user_group!=null){
        return $user_group;
      }
    }else{
      return null;
    }
    return null;
  }
  /**
   * 验证用户的权限是否满足 only_no项如果true则只有没有xx项目才能xx
   * @param string $token token字符串
   * @param string $name 权限名称 
   * @param string $ability = [
   * @param string 'ability_normal_login',//用户前台登录
   * @param string 'ability_admin_login',//管理员登录
   * @param string 'ability_admin_manage_user_group',//管理员管理用户组
   * @param string 'ability_admin_manage_user',//管理员管理用户
   * @param string 'ability_admin_manage_topic',//管理员管理话题
   * @param string 'ability_admin_manage_question',//管理员管理问题
   * @param string 'ability_admin_manage_article',//管理员管理文章
   * @param string 'ability_admin_manage_comment',//管理员管理评论
   * @param string 'ability_admin_manage_answer',//管理员管理回答
   * @param string 'ability_admin_manage_reply',//管理员管理回复
   * @param string 'ability_admin_manage_report',//管理员管理举报
   * @param string 'ability_create_article',//创建文章
   * @param string 'ability_create_question',//创建问题
   * @param string 'ability_create_answer',//创建回答
   * @param string 'ability_create_comment',//创建评论
   * @param string 'ability_create_reply',//创建回复
   * @param string 'ability_create_topic',//创建话题
   * @param string 'ability_edit_own_article',//编辑自己的文章
   * @param string 'ability_edit_own_question',//编辑自己的问题
   * @param string 'ability_edit_own_answer',//编辑自己的回答
   * @param string 'ability_edit_own_comment',//编辑自己的评论
   * @param string 'ability_edit_own_reply',//编辑自己的回复
   * @param string 'ability_edit_own_topic',//编辑自己的话题
   * @param string 'ability_delete_own_article',//删除自己的文章
   * @param string 'ability_delete_own_question',//删除自己的问题
   * @param string 'ability_delete_own_answer',//删除自己的回答
   * @param string 'ability_delete_own_comment',//删除自己的评论
   * @param string 'ability_delete_own_reply',//删除自己的回复
   * @param string 'ability_delete_own_topic',//删除自己的话题
   * @param string 'ability_edit_article_only_no_comment',//仅限文章没有评论的情况下才能编辑
   * @param string 'ability_edit_question_only_no_answer',//仅限问题没有回答的情况下才能编辑
   * @param string 'ability_edit_answer_only_no_comment',//仅限回答没有评论的情况下才能编辑
   * @param string 'ability_edit_question_only_no_comment',//仅限问题没有评论的情况下才能编辑
   * @param string 'ability_edit_comment_only_no_reply',//仅限评论没有回复的情况下才能编辑
   * @param string 'ability_edit_topic_only_no_article_or_question',//仅限话题没有文章或问题的情况下才能编辑
   * @param string 'ability_delete_article_only_no_comment',//仅限文章没有评论的情况下才能删除
   * @param string 'ability_delete_question_only_no_answer',//仅限问题没有回答的情况下才能删除
   * @param string 'ability_delete_answer_only_no_comment',//仅限回答没有评论的情况下才能删除
   * @param string 'ability_delete_question_only_no_comment',//仅限问题没有评论的情况下才能删除
   * @param string 'ability_delete_comment_only_no_reply',//仅限评论没有回复的情况下才能删除
   * @param string 'ability_delete_topic_only_no_article_or_question',//仅限话题没有文章或问题的情况下才能删除
   * @param string 'ability_edit_own_info'//编辑自己的个人信息
   * @param string '];
   * @return bool 是否满足
   */
  public static function Ability($token,$name):bool
  {
    $ability = [
      'ability_normal_login',
      'ability_admin_login',
      'ability_admin_manage_user_group',
      'ability_admin_manage_user',
      'ability_admin_manage_topic',
      'ability_admin_manage_question',
      'ability_admin_manage_article',
      'ability_admin_manage_comment',
      'ability_admin_manage_answer',
      'ability_admin_manage_reply',
      'ability_admin_manage_report',
      'ability_create_article',
      'ability_create_question',
      'ability_create_answer',
      'ability_create_comment',
      'ability_create_reply',
      'ability_create_topic',
      'ability_edit_own_article',
      'ability_edit_own_question',
      'ability_edit_own_answer',
      'ability_edit_own_comment',
      'ability_edit_own_reply',
      'ability_edit_own_topic',
      'ability_delete_own_article',
      'ability_delete_own_question',
      'ability_delete_own_answer',
      'ability_delete_own_comment',
      'ability_delete_own_reply',
      'ability_delete_own_topic',
      'ability_edit_article_only_no_comment',
      'ability_edit_question_only_no_answer',
      'ability_edit_answer_only_no_comment',
      'ability_edit_question_only_no_comment',
      'ability_edit_comment_only_no_reply',
      'ability_edit_topic_only_no_article_or_question',
      'ability_delete_article_only_no_comment',
      'ability_delete_question_only_no_answer',
      'ability_delete_answer_only_no_comment',
      'ability_delete_question_only_no_comment',
      'ability_delete_comment_only_no_reply',
      'ability_delete_topic_only_no_article_or_question',
      'ability_edit_own_info'
    ];
    //如果$name不在$ability中，返回false
    if(!in_array($name,$ability)){
      return false;
    }
    $user_group = self::where('user_group_id', '=', TokenCollector::GetUser($token)->user_group_id)->first();
    if($user_group!=null){
      if($user_group->$name==true){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
  /**
   * 获取用户的权限
   * @param string $token token字符串
   * @param string $name 权限名称
   * @param string $ability = [
   * @param string 'time_before_edit_article',//在多长时间前可编辑自己的文章（单位：分钟，0无限期）
   * @param string 'time_before_edit_question',//在多长时间前可编辑自己的问题（单位：分钟，0无限期）
   * @param string 'time_before_edit_answer',//在多长时间前可编辑自己的回答（单位：分钟，0无限期）
   * @param string 'time_before_edit_comment',//在多长时间前可编辑自己的评论（单位：分钟，0无限期）
   * @param string 'time_before_edit_reply',//在多长时间前可编辑自己的回复（单位：分钟，0无限期）
   * @param string 'time_before_edit_topic',//在多长时间前可编辑自己的话题（单位：分钟，0无限期）
   * @param string 'time_before_delete_article',//在多长时间前可删除自己的文章（单位：分钟，0无限期）
   * @param string 'time_before_delete_question',//在多长时间前可删除自己的问题（单位：分钟，0无限期）
   * @param string 'time_before_delete_answer',//在多长时间前可删除自己的回答（单位：分钟，0无限期）
   * @param string 'time_before_delete_comment',//在多长时间前可删除自己的评论（单位：分钟，0无限期）
   * @param string 'time_before_delete_reply',//在多长时间前可删除自己的回复（单位：分钟，0无限期）
   * @param string 'time_before_delete_topic',//在多长时间前可删除自己的话题（单位：分钟，0无限期）
   * @param string '];
   * @return int 权限值
   */
  public static function BeforeTime($token,$name):int
  {
    $time_before = [
      'time_before_edit_article',
      'time_before_edit_question',
      'time_before_edit_answer',
      'time_before_edit_comment',
      'time_before_edit_reply',
      'time_before_edit_topic',
      'time_before_delete_article',
      'time_before_delete_question',
      'time_before_delete_answer',
      'time_before_delete_comment',
      'time_before_delete_reply',
      'time_before_delete_topic'
    ];
    //如果$name不在$time_before中，返回false
    if(!in_array($name,$time_before)){
      return 0;
    }
    $user_group = self::where('user_group_id', '=', TokenCollector::GetUser($token)->user_group_id)->first();
    if($user_group!=null){
      return $user_group->$name;
    }else{
      return 0;
    }
  }
}