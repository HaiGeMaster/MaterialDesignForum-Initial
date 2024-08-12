<?php

namespace MaterialDesignForum\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
class UserGroup extends Eloquent
{
  protected $table = 'user_group';
  public $timestamps = false;
  protected $primaryKey = 'user_group_id';
  protected $fillable = [
    'user_group_id',
    'user_group_name',
    'user_group_description',
    'user_group_icon',
    'user_group_color',
    'user_group_user_count',
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
  protected $casts = [
    'ability_normal_login' => 'boolean',
    'ability_admin_login' => 'boolean',
    'ability_admin_manage_user_group' => 'boolean',
    'ability_admin_manage_user' => 'boolean',
    'ability_admin_manage_topic' => 'boolean',
    'ability_admin_manage_question' => 'boolean',
    'ability_admin_manage_article' => 'boolean',
    'ability_admin_manage_comment' => 'boolean',
    'ability_admin_manage_answer' => 'boolean',
    'ability_admin_manage_reply' => 'boolean',
    'ability_admin_manage_report' => 'boolean',
    'ability_create_article' => 'boolean',
    'ability_create_question' => 'boolean',
    'ability_create_answer' => 'boolean',
    'ability_create_comment' => 'boolean',
    'ability_create_reply' => 'boolean',
    'ability_create_topic' => 'boolean',
    'ability_edit_own_article' => 'boolean',
    'ability_edit_own_question' => 'boolean',
    'ability_edit_own_answer' => 'boolean',
    'ability_edit_own_comment' => 'boolean',
    'ability_edit_own_reply' => 'boolean',
    'ability_edit_own_topic' => 'boolean',
    'ability_delete_own_article' => 'boolean',
    'ability_delete_own_question' => 'boolean',
    'ability_delete_own_answer' => 'boolean',
    'ability_delete_own_comment' => 'boolean',
    'ability_delete_own_reply' => 'boolean',
    'ability_delete_own_topic' => 'boolean',
    'ability_edit_article_only_no_comment' => 'boolean',
    'ability_edit_question_only_no_answer' => 'boolean',
    'ability_edit_answer_only_no_comment' => 'boolean',
    'ability_edit_question_only_no_comment' => 'boolean',
    'ability_edit_comment_only_no_reply' => 'boolean',
    'ability_edit_topic_only_no_article_or_question' => 'boolean',
    'ability_delete_article_only_no_comment' => 'boolean',
    'ability_delete_question_only_no_answer' => 'boolean',
    'ability_delete_answer_only_no_comment' => 'boolean',
    'ability_delete_question_only_no_comment' => 'boolean',
    'ability_delete_comment_only_no_reply' => 'boolean',
    'ability_delete_topic_only_no_article_or_question' => 'boolean',
    'ability_edit_own_info' => 'boolean'
  ];
  /**
   * 增加用户组人数
   * @param int $user_group_id 用户组ID
   * @return bool 是否成功
   */
  public static function AddUserGroupUserCount($user_group_id,$count = 1): bool
  {
    $user_group = self::find($user_group_id);
    if ($user_group) {
      $user_group->user_group_user_count = $user_group->user_group_user_count + $count;
      return $user_group->save();
    } else {
      return false;
    }
  }
  /**
   * 减少用户组人数
   * @param int $user_group_id 用户组ID
   * @return bool 是否成功
   */
  public static function SubUserGroupUserCount($user_group_id,$count = 1): bool
  {
    $user_group = self::find($user_group_id);
    if ($user_group) {
      $user_group->user_group_user_count = $user_group->user_group_user_count - $count;
      return $user_group->save();
    } else {
      return false;
    }
  }
}