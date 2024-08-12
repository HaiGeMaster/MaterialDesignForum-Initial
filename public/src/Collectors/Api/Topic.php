<?php

namespace MaterialDesignForum\Collectors\Api;

use MaterialDesignForum\Models\Topic as TopicModel;

class Topic extends TopicModel
{
  /**
   * 获取话题
   * @param int $topic_id 话题ID
   * @return Topic|null 话题
   */
  public static function GetTopic($topic_id)
  {
    $topic = self::find($topic_id);
    if ($topic) {
      return $topic;
    } else {
      return null;
    }
  }
  /**
   * 增加文章
   * @param int $user_token 用户token
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function AddTopic($user_token,$name, $cover, $description): bool
  {
    $topic = new self();
    $topic->name = $name;
    $topic->cover = $cover;
    $topic->description = $description;
    $topic->article_count = 0;
    $topic->question_count = 0;
    $topic->follower_count = 0;
    $topic->create_time = time();
    return $topic->save();
  }
  /**
   * 编辑话题
   * @param int $user_token 用户token
   * @param int $topic_id 话题ID
   * @param string $name 话题名称
   * @param string $cover 封面图片token
   * @param string $description 话题描述
   * @return bool 是否成功
   */
  public static function EditTopic($user_token,$topic_id, $name, $cover, $description): bool
  {
    $topic = self::GetTopic($topic_id);
    if ($topic) {
      $topic->name = $name;
      $topic->cover = $cover;
      $topic->description = $description;
      return $topic->save();
    } else {
      return false;
    }
  }
  /**
   * 删除话题
   * @param int $user_token 用户token
   * @param int $topic_id 话题ID
   * @return bool 是否成功
   */
  public static function DeleteTopic($user_token,$topic_id): bool
  {
    $topic = self::GetTopic($topic_id);
    if ($topic) {
      $topic->delete_time = time();
      return $topic->save();
    } else {
      return false;
    }
  }
}
