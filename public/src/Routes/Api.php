<?php

namespace MaterialDesignForum\Routes;

use MaterialDesignForum\Plugins\Share;
use MaterialDesignForum\Config\Config;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class Api
{
  /**
   * 处理API
   */
  public static function HandleAPI()
  {
    $collector = new RouteCollector();
    /**
     * 请求发送邮件验证码，格式/api/user/email_captcha,{email:邮箱,lang:语言?}
     * @return json {send_mail:发送的邮箱,is_send:是否发送成功,email_code:邮箱验证码,locale:语言}
     */
    $collector->post('/api/user/email_captcha', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_GetEmailCaptcha($data['email'], $data['email']);
    });
    /**
     * 请求图片验证码，格式/api/user/image_captcha
     * @return img 图片验证码
     */
    $collector->get('/api/user/image_captcha/{time}?', [
      \MaterialDesignForum\Collectors\Api\User::class,
      'API_GetImageCaptcha'
    ]);
    /**
     * 请求用户信息，格式/api/user/auto_login,{user_token:登录用户token字符串*}
     * @return json {is_login:是否登录成功,user:用户信息}
     */
    $collector->post('/api/user/auto_login', function () {
      $data = Share::GetRequestData()['user_token'];
      return \MaterialDesignForum\Collectors\Api\User::API_UserUseTokenLogin($data);
    });
    /**
     * 请求注册用户，格式/api/user/register,{email:邮箱,password:密码,email_captcha:邮箱验证码,username:用户名?}
     * @return json {is_register:是否注册成功}
     */
    $collector->post('/api/user/register', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_CreateUser($data['email'], $data['password'], $data['email_captcha'], $data['username']);
    });
    /**
     * 请求登录验证，格式/api/user/login,{emailorname:邮箱或用户名,password:密码,images_captcha:验证码}
     * @return json {is_login:是否登录成功,token:token字符串}
     */
    $collector->post('/api/user/login', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_Login($data['emailorname'], $data['password'], $data['images_captcha']);
    });
    /**
     * 请求修改用户密码，格式/api/user/reset,{email:邮箱,password:密码,email_captcha:邮箱验证码}
     * @return json {is_reset:是否重置成功}
     */
    $collector->post('/api/user/reset', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_Reset($data['email'], $data['password'], $data['email_captcha']);
    });
    /**
     * 根据 user_id 请求用户信息，格式/api/user/get,{user_id:用户id,user_token:登录用户token字符串?}
     * @return json {is_get:是否获取成功,user:用户信息}
     */
    $collector->post('/api/user/get', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_GetUser($data['user_id'], $data['user_token']);
    });
    /**
     * 请求用户列表，格式/api/users/get,{type:类型,page:页数,user_token:登录用户token字符串?}
     * @return json {is_get:是否获取成功,data:用户列表,pagination:分页信息,message:消息}
     */
    $collector->post('/api/users/get', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_GetUsers($data['type'], $data['page'], $data['user_token']);
    });
    /**
     * 请求用户关注对象，格式/api/user/follows,{user_token:登录用户token字符串,followable_type:关注对象类型,followable_id:关注对象id}
     * @return json {is_follow:是否关注}
     */
    $collector->post('/api/user/follow', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\Follow::API_Follow($data['user_token'], $data['followable_type'], $data['followable_id'], true);
    });
    /**
     * 重置所有用户的头像，格式/api/dev/DEV_API_AllUserAvatarReset
     * @return json {is_reset:是否重置成功}
     */
    $collector->get('/api/dev/DEV_API_AllUserAvatarReset', function () {
      if(!Config::Dev()){
        return ['is_reset' => false, 'message' => '!Config::Dev()'];
      }
      return \MaterialDesignForum\Collectors\Api\User::DEV_API_AllUserAvatarReset();
    });
    /**
     * 请求更新用户的简介，格式/api/user/editinfo,{username:用户名,headline:一句话介绍,blog:个人主页,company:所属学校或企业,location:所在地,bio:个人介绍,user_token:登录用户token字符串(必须是本人或管理员),edit_target_user_id:要编辑的用户id}
     * @return json {is_edit:是否更新成功,user:新的用户信息}
     */
    $collector->post('/api/user/editinfo', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_EditInfo($data['username'], $data['headline'], $data['blog'], $data['company'], $data['location'], $data['bio'], $data['user_token'], $data['edit_target_user_id']);
    });
    $collector->post('/api/follow/get', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\Follow::API_GetFollow($data['modes'],$data['type'], $data['followable_id'],$data['page'], $data['user_token']);
    });
    $collector->post('/api/user/avatar/upload', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_UploadAvatar($data['user_token'], $data['avatar']);
    });
    $collector->post('/api/user/cover/upload', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\User::API_UploadCover($data['user_token'], $data['cover']);
    });
    $collector->post('/api/topic/create', function () {
      $data = Share::GetRequestData();
      return \MaterialDesignForum\Collectors\Api\Topic::API_CreateTopic($data['title'], $data['content'], $data['topic_cover'],$data['user_token']);
    });
    $dispatcher =  new Dispatcher($collector->getData());
    return $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  }
  public static function IsApi()
  {
    return strpos(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 'api') !== false;
  }
}
