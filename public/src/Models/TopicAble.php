<?php

namespace MaterialDesignForum\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class TopicAble extends Eloquent{
  protected $table = 'topicable';
  public $timestamps = false;
  protected $fillable = [
    'topic_id',// 话题ID
    'topicable_id',// 话题关系对应的 question、article ID,例如 文章:话题[1,2,3,4,5]
    'topicable_type',// 话题关系对应的类型 question、article
    'create_time',// 创建时间
  ];
}