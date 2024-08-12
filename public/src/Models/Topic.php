<?php

namespace MaterialDesignForum\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Topic extends Eloquent
{
  protected $table = 'topic';
  public $timestamps = false;
  protected $primaryKey = 'topic_id';
  protected $fillable = [
    'topic_id', // 话题ID 主键
    'user_id', // 用户ID 话题创建者用户id
    'name', // 话题名称
    'cover', // 封面图片token
    'description', // 话题描述
    'article_count', // 文章数量
    'question_count', // 问题数量
    'follower_count', // 关注者数量
    'delete_time' // 删除时间
  ];
  /**
   * 增加文章数量
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function AddArticleCount($topic_id): bool
  {
    $topic = self::find($topic_id);
    if ($topic) {
      $topic->article_count = $topic->article_count + 1;
      return $topic->save();
    } else {
      return false;
    }
  }
  /**
   * 减少文章数量
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function SubArticleCount($topic_id): bool
  {
    $topic = self::find($topic_id);
    if ($topic) {
      $topic->article_count = $topic->article_count - 1;
      return $topic->save();
    } else {
      return false;
    }
  }
  /**
   * 增加问题数量
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function AddQuestionCount($topic_id): bool
  {
    $topic = self::find($topic_id);
    if ($topic) {
      $topic->question_count = $topic->question_count + 1;
      return $topic->save();
    } else {
      return false;
    }
  }
  /**
   * 减少问题数量
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function SubQuestionCount($topic_id): bool
  {
    $topic = self::find($topic_id);
    if ($topic) {
      $topic->question_count = $topic->question_count - 1;
      return $topic->save();
    } else {
      return false;
    }
  }
  /**
   * 增加关注者数量
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function AddFollowerCount($topic_id): bool
  {
    $topic = self::find($topic_id);
    if ($topic) {
      $topic->follower_count = $topic->follower_count + 1;
      return $topic->save();
    } else {
      return false;
    }
  }
  /**
   * 减少关注者数量
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function SubFollowerCount($topic_id): bool
  {
    $topic = self::find($topic_id);
    if ($topic) {
      $topic->follower_count = $topic->follower_count - 1;
      return $topic->save();
    } else {
      return false;
    }
  }
}
