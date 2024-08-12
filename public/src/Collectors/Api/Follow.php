<?php

namespace MaterialDesignForum\Collectors\Api;

use MaterialDesignForum\Models\Follow as FollowModel;
use MaterialDesignForum\Models\User as UserModel;
use MaterialDesignForum\Collectors\Api\Token as TokenCollector;
use MaterialDesignForum\Plugins\Share;

class Follow extends FollowModel
{
  /**
   * 关注
   * @param int $user_id 用户ID
   * @param string $followable_type 关注类型
   * @param int $followable_id 关注ID
   * @param bool $isTokenUser 是否是token用户
   * @return array is_follow:是否关注
   */
  public static function IsFollow($user_token_or_id, $followable_type, $followable_id, $isTokenUser = false): bool
  {
    $user_id = !$isTokenUser ? $user_token_or_id : TokenCollector::GetUserId($user_token_or_id);
    $follow = self::where('user_id', $user_id)->where('followable_type', $followable_type)->where('followable_id', $followable_id)->first();
    if ($follow) {
      return true;
    } else {
      return false;
    }
  }
  /**
   * 关注或取消关注
   * @param int $user_id 用户ID
   * @param string $followable_type 关注类型
   * @param int $followable_id 关注ID
   * @param bool $isTokenUser 是否是token用户
   * @return string is_follow:是否关注 json
   */
  public static function API_Follow($user_token_or_id, $followable_type, $followable_id, $isTokenUser = false): string
  {
    $user_id = !$isTokenUser ? $user_token_or_id : TokenCollector::GetUserId($user_token_or_id);
    $follow = self::where('user_id', $user_id)->where('followable_type', $followable_type)->where('followable_id', $followable_id)->first();
    if ($follow) {
      $delete = self::where('user_id', $user_id)->where('followable_type', $followable_type)->where('followable_id', $followable_id)->delete();
      if ($delete != null) {
        switch ($followable_type) {
          case 'user':
            UserModel::SubFollowerCount($followable_id);
            UserModel::SubFolloweeCount($user_id);
            break;
        }
      }
      $data = array('is_follow' => !$delete);
      return Share::HandleArrayToJSON($data);
    } else {
      $follow = new self();
      $follow->user_id = $user_id;
      $follow->followable_type = $followable_type;
      $follow->followable_id = $followable_id;
      $follow->create_time = time();
      if ($follow) {
        switch ($followable_type) {
          case 'user':
            UserModel::AddFollowerCount($followable_id);
            UserModel::AddFolloweeCount($user_id);
            break;
        }
      }
      $data = array('is_follow' => $follow->save());
      return Share::HandleArrayToJSON($data);
    }
  }
  /**
   * 获取用户对象的关注列表 A关注了N个对象
   * @param int $user_id 对象ID
   * @param string $followable_type 关注类型 user，topic，question，articles
   * @param int $page 页数
   * @param string $user_token 用户token
   * @param int $per_page 每页显示数量
   * @param bool $is_admin 是否是管理员
   * @return array||null $[data,pagination] data:用户关注ID列表 pagination:分页信息
   */
  public static function GetFolloweesList($object_id, $followable_type, $page = 1, $user_token = '', $per_page = 20, $is_admin = false): array
  {
    $follow_list = self::where('user_id', '=', $object_id)
      ->where('followable_type', '=', $followable_type)
      ->paginate($per_page, ['*'], 'page', $page);
    $data = null;
    $pagination = null;
    $followable_id_list = array();
    if ($follow_list) {
      $follow_list_data = $follow_list->items();
      foreach ($follow_list_data as $key => $value) {
        array_push($followable_id_list, $value['followable_id']);
      }
      $data = UserModel::whereIn('user_id', $followable_id_list)->get();
      if ($user_token) {
        foreach ($data as $key => $value) {
          $data[$key]['is_follow'] = self::IsFollow($user_token, 'user', $value['user_id'], true);
          if (!$is_admin) {
            foreach ($data as $key => $value) {
              $data[$key]['password'] = '';
              $data[$key]['email'] = '';
            }
          }
        }
      }
      $previousPageUrl = $follow_list->previousPageUrl();
      $nextPageUrl = $follow_list->nextPageUrl();
      $previousPageUrl = $previousPageUrl != null ? str_replace('/?page=', '', $previousPageUrl) : null;
      $nextPageUrl = $nextPageUrl != null ? str_replace('/?page=', '', $nextPageUrl) : null;
      $pagination = [
        'page' => $follow_list->currentPage(),
        'per_page' => $follow_list->perPage(),
        'total' => $follow_list->total(),
        'pages' => $follow_list->lastPage(),
        'previous' => $previousPageUrl,
        'next' => $nextPageUrl,
      ];
    }
    return Share::CommonPaginationDataPack(
      true,
      $data,
      $pagination,
      '',
    );
  }
  /**
   * 获取对象的粉丝列表 A被N个对象关注
   * @param int $user_id 对象ID
   * @param string $followable_type 关注类型 user，topic，question，articles
   * @param int $page 页数
   * @param string $user_token 用户token
   * @param int $per_page 每页显示数量
   * @param bool $is_admin 是否是管理员
   * @return array||null $[data,pagination] data:用户关注ID列表 pagination:分页信息
   */
  public static function GetFollowersList($object_id, $followable_type, $page = 1, $user_token = '', $per_page = 20, $is_admin = false): array
  {
    $follow_list = self::where('followable_id', '=', $object_id)
      ->where('followable_type', '=', $followable_type)
      ->paginate($per_page, ['user_id'], 'page', $page);
    $data = null;
    $pagination = null;
    $user_id_list = array();
    if ($follow_list) {
      $follow_list_data = $follow_list->items();
      foreach ($follow_list_data as $key => $value) {
        array_push($user_id_list, $value['user_id']);
      }
      $data = UserModel::whereIn('user_id', $user_id_list)->get();
      if ($user_token) {
        foreach ($data as $key => $value) {
          $data[$key]['is_follow'] = self::IsFollow($user_token, 'user', $value['user_id'], true);
          if (!$is_admin) {
            foreach ($data as $key => $value) {
              $data[$key]['password'] = '';
              $data[$key]['email'] = '';
            }
          }
        }
      }
      $previousPageUrl = $follow_list->previousPageUrl();
      $nextPageUrl = $follow_list->nextPageUrl();
      $previousPageUrl = $previousPageUrl != null ? str_replace('/?page=', '', $previousPageUrl) : null;
      $nextPageUrl = $nextPageUrl != null ? str_replace('/?page=', '', $nextPageUrl) : null;
      $pagination = [
        'page' => $follow_list->currentPage(),
        'per_page' => $follow_list->perPage(),
        'total' => $follow_list->total(),
        'pages' => $follow_list->lastPage(),
        'previous' => $previousPageUrl,
        'next' => $nextPageUrl,
      ];
    }
    return Share::CommonPaginationDataPack(
      true,
      $data,
      $pagination,
      ''
    );
  }
  public static function API_GetFollow($modes, $followable_type, $followable_id, $page, $user_token = '', $per_page = 20, $is_admin = false)
  {
    $data = Share::CommonPaginationDataPack(
      false,
      null,
      null,
      ''
    );
    if ($modes == 'followers') {
      if ($user_token) {
        $data = self::GetFollowersList($followable_id || TokenCollector::GetUserId($user_token), $followable_type, $page, $user_token, $per_page, $is_admin);
      } else {
        $data = self::GetFollowersList($followable_id || TokenCollector::GetUserId($user_token), $followable_type, $page, $user_token, $per_page, $is_admin);
      }
    } else if ($modes == 'followees') {
      if ($user_token) {
        $data = self::GetFolloweesList($followable_id || TokenCollector::GetUserId($user_token), $followable_type, $page, $user_token, $per_page, $is_admin);
      } else {
        $data = self::GetFolloweesList($followable_id || TokenCollector::GetUserId($user_token), $followable_type, $page, $user_token, $per_page, $is_admin);
      }
    }
    return Share::HandleArrayToJSON($data);
  }
}
