<?php

namespace MaterialDesignForum\Collectors\Api;

use itbdw\Ip\IpLocation;

use MaterialDesignForum\Models\MailCaptcha as MailCaptchaModel;
use MaterialDesignForum\Models\ImageCaptcha as ImageCaptchaModel;
use MaterialDesignForum\Models\User as UserModel;
use MaterialDesignForum\Models\Cache as CacheModel;
use MaterialDesignForum\Models\Token as TokenModel;
use MaterialDesignForum\Models\Image as ImageModel;
use MaterialDesignForum\Models\UserGroup as UserGroupModel;
use MaterialDesignForum\Collectors\Api\UserGroup as UserGroupCollector;
use MaterialDesignForum\Collectors\Api\Token as TokenCollector;
use MaterialDesignForum\Collectors\Api\Follow as FollowModel;
use MaterialDesignForum\Config\Config;
use MaterialDesignForum\Plugins\i18n;
use MaterialDesignForum\Plugins\Share;

//use Illuminate\Pagination\Paginator;

class User extends UserModel
{
  public static function UploadAvatar($user_id, $avatar_base64)
  {
    return ImageModel::SaveImage('user_avatar', $avatar_base64, $user_id);
  }
  public static function UploadCover($user_id, $cover_base64)
  {
    return ImageModel::SaveImage('user_cover', $cover_base64, $user_id);
  }
  public static function CreateDefaultAvatar($name, $user_id = 'cache'){
    return ImageModel::CreateUserDefaultAvatar($name, $user_id);
  }
  /**
   * 获取客户端IP地址
   */
  public static function GetClientIP()
  {
    $client_ip = '0.0.0.0';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $client_ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
      $client_ip = $_SERVER['REMOTE_ADDR'];
    }
    return $client_ip;
  }
  /**
   * 获取客户端IP地址的地理位置
   * // 返回结果
   *  array (size=4)
   *    0 => string '中国' (length=6)
   *    1 => string '河南' (length=6)
   *    2 => string '郑州' (length=6)
   *    3 => string '' (length=0)
   *    4 => string '410100' (length=6)
   */
  public static function GetClientLocation()
  {
    // $client_ip = self::GetClientIP();
    // $ip = Ip::find($client_ip);
    // //$location = $ip->getIpLocation();
    // return $ip[0].' '.$ip[1].' '.$ip[2]; //$location;
    $ip = self::GetClientIP();
    $Location = IpLocation::getLocation($ip);
    //return $Location;
    //$Location = json_encode($Location, JSON_UNESCAPED_UNICODE);
    //$Location = json_decode($Location, true);
    //将$Location数组转换为对象，然后再转换为json字符串
    //$Location = json_encode((object)$Location, JSON_UNESCAPED_UNICODE);

    //return $Location;
    //return $Location->country . ' ' . $Location->province . ' ' . $Location->city . ' ' . $Location->county . ' ' . $Location->isp;
    return $Location['country'] . ' ' . $Location['province'] . ' ' . $Location['city'] . ' ' . $Location['county'] . ' ' . $Location['isp'];
  }
  /**
   * 请求发送邮件验证码
   * @param string $email 邮箱
   * @param string $lang 语言 如zh_CN 必须来自客户端界面支持的语言 可选的 i18n将会自动检测并设置。
   * @return json {send_mail:发送的邮箱,is_send:是否发送成功,email_code:邮箱验证码,locale:语言}
   */
  public static function API_GetEmailCaptcha($email, $lang = "")
  {
    $Client_email = base64_decode($email);
    $Client_lang = base64_decode($lang);
    $v = false;
    $config = Config::getConfig();
    $MailCaptcha = new MailCaptchaModel();
    $Captcha = $MailCaptcha->CreateMailCode();
    if ($Client_lang != '') {
      i18n::i18n()->setLocale($Client_lang);
    }
    $v = $MailCaptcha->SendMail(
      $Client_email,
      $config['smtp_send_name'] . ':' . i18n::t('Message.Components.Account.Code'),
      $Captcha['code']
    );
    CacheModel::create([
      'name' => $Captcha['md5code'],
      'value' => $Captcha['code'],
      'create_time' => time(),
      'life_time' => time() + (60 * 5)
    ]);
    $data = array(
      'is_send' => $v,
    );
    if (Config::Dev()) {
      $data['dev_client_send_mail'] = $Client_email;
      $data['dev_client_email_code'] = $Captcha['md5code'];
      $data['dev_client_locale'] = $Client_lang;
    }
    return Share::HandleArrayToJSON($data);
  }
  /**
   * 请求图片验证码
   * @return img 图片验证码
   */
  public static function API_GetImageCaptcha($time = 0)
  {
    $ImageCaptcha = new ImageCaptchaModel();
    $Captcha = $ImageCaptcha->CreateImgAndCode();
    CacheModel::create([
      'name' => $Captcha['md5code'],
      'value' => $Captcha['code'],
      'create_time' => time(),
      'life_time' => time() + (60 * 5)
    ]);
    return $ImageCaptcha->OutputImg();
  }
  /**
   * 请求注册用户
   * @param string $email 邮箱
   * @param string $password 密码
   * @param string $email_captcha 邮箱验证码
   * @param string $username 用户名
   * @return json {is_register:是否注册成功}
   */
  public static function API_CreateUser($email, $password, $email_captcha, $username = "")
  {
    $v = false;
    $Client_email = base64_decode($email);
    $Client_password = self::HandlePassword(base64_decode($password)); //base64_decode($password);
    $Client_email_captcha = md5(base64_decode($email_captcha));
    $Client_username = base64_decode($username);
    if ($Client_username == "") {
      $Client_username = $Client_email;
    }
    $Client_user = self::where('email', '=', $Client_email)->first() == null;
    if($Client_user){
      $Client_user = self::where('username', '=', $Client_username)->first() == null;
      if($Client_user){
        if(CacheModel::IsVaildCaptcha($Client_email_captcha)){
          $user = new self();
          if (self::count() == 0) {
            $user->user_group_id = 1;
          }else{
            $user->user_group_id = 2;
          }
          $user->email = $Client_email;
          $user->password = $Client_password;
          $user->username = $Client_username;
          $user->create_ip = self::GetClientIP();
          $user->create_location =  self::GetClientLocation();
          $user->location = self::GetClientLocation();
          $user->create_time = time();
          $user->avatar = self::CreateDefaultAvatar($Client_username);
          $v = $user->save();
          if ($v) {
            $add = UserGroupModel::AddUserGroupUserCount($user->user_group_id);
            while(!$add){
              $add = UserGroupModel::AddUserGroupUserCount($user->user_group_id);
            }
            CacheModel::DeleteCaptcha($Client_email_captcha);
          }
        }
      }
    }


    // $Client_cache = CacheModel::where('name', '=', $Client_email_captcha)
    //   ->where('life_time', '>', time())
    //   ->first() != null;
    // $Client_user = self::where('email', '=', $Client_email)
    //   ->orWhere('username', '=', $Client_email)->first() == null;
    // if ($Client_cache && $Client_user) {
    //   $user = new self();
    //   if (self::count() == 0) {
    //     $user->user_group_id = 1;
    //   }else{
    //     $user->user_group_id = 2;
    //   }
    //   $user->email = $Client_email;
    //   $user->password = $Client_password;
    //   $user->username = $Client_username;
    //   $user->create_ip = self::GetClientIP();
    //   $user->create_location =  self::GetClientLocation();
    //   $user->location = self::GetClientLocation();
    //   $user->create_time = time();
    //   $user->avatar = self::CreateDefaultAvatar($Client_username);
    //   //$user->avatar = Share::HandleArrayToJSON(self::CreateDefaultAvatar($user->username));
    //   $v = $user->save();
    //   $add = UserGroupModel::AddUserGroupUserCount($user->user_group_id);
    //   if ($v) {
    //     while(!$add){
    //       $add = UserGroupModel::AddUserGroupUserCount($user->user_group_id);
    //     }
    //     //if (!Config::Dev()) {
    //       //删除验证码
    //       CacheModel::where('name', '=', $Client_email_captcha)->delete();
    //       //删除过期的验证码
    //       CacheModel::where('life_time', '<', time())->delete();
    //     //}
    //   }
    // }
    $data = array(
      'is_add' => $v,
    );
    return Share::HandleArrayToJSON($data);
  }
  /**
   * 请求登录验证
   * @param string $email 邮箱
   * @param string $password 密码
   * @param string $images_captcha 验证码
   * @return json {is_login:是否登录成功,token:token字符串}
   */
  public static function API_Login($emailorname, $password, $images_captcha = "")
  {
    $v = false;

    $Client_emailorname = base64_decode($emailorname);
    $Client_password = self::HandlePassword(base64_decode($password));
    $Client_images_captcha = $images_captcha ? md5(base64_decode($images_captcha)) : '';

    $Client_cache = false;
    if($Client_images_captcha != ''){
      $Client_cache = CacheModel::IsVaildCaptcha($Client_images_captcha);
    }

    $Client_user = self::where('email', '=', $Client_emailorname)->first();

    if($Client_user == null){
      $Client_user = self::where('username', '=', $Client_emailorname)->first();
    }

    $Return_token = '';
    if($Client_user!=null){
      if($Client_user->password == $Client_password&&($Client_images_captcha==''||$Client_cache)){
        $Server_token = TokenModel::where('user_id', '=', $Client_user->user_id)->first();
        if($Server_token){
          $Client_device = $_SERVER['HTTP_USER_AGENT']; //客户端设备
          $Client_token = md5($Client_user->email . $Client_user->password . $Client_device);
          $Client_expire_time = time() + (60 * 60 * 24 * 7); //过期时间
          $Update_token = TokenModel::where('user_id', '=', $Client_user->user_id)->update([
            'token' => $Client_token,
            'device' => $Client_device,
            'update_time' => time(),
            'expire_time' => $Client_expire_time,
          ]);
          if($Update_token){
            $Update_user = self::find($Client_user->user_id)->update([
              'last_login_ip' => self::GetClientIP(),
              'last_login_location' => self::GetClientLocation(),
              'last_login_time' => time(),
            ]);
            if($Update_user){
              //删除验证码
              if($Client_images_captcha != ''){
                CacheModel::DeleteCaptcha($Client_images_captcha);
              }
              $Return_token = $Client_token;
              $v = true;
            }
          }
        }else{
          $Client_device = $_SERVER['HTTP_USER_AGENT']; //客户端设备
          $Client_token = md5($Client_user->email . $Client_user->password . $Client_device);
          $Client_expire_time = time() + (60 * 60 * 24 * 7); //过期时间
          $Create_token = TokenModel::create([
            'token' => $Client_token,
            'user_id' => $Client_user->user_id,
            'device' => $Client_device,
            'create_time' => time(),
            'update_time' => time(),
            'expire_time' => $Client_expire_time,
          ]);
          if($Create_token){
            $Update_user = self::find($Client_user->user_id)->update([
              'last_login_ip' => self::GetClientIP(),
              'last_login_location' => self::GetClientLocation(),
              'last_login_time' => time(),
            ]);
            if($Update_user){
              //删除验证码
              if($Client_images_captcha != ''){
                CacheModel::DeleteCaptcha($Client_images_captcha);
              }
              $Return_token = $Client_token;
              $v = true;
            }
          }
        }
      }
    }
    $data = array(
      'is_login' => $v,
      'token' => $Return_token,
    );
    return Share::HandleArrayToJSON($data);
  }
  /**
   * 请求修改用户密码
   * @param string $email 邮箱
   * @param string $email_captcha 邮箱验证码
   * @param string $password 密码
   * @return json {is_reset:是否重置成功}
   */
  public static function API_Reset($email, $password, $email_captcha)
  {
    $Client_email = base64_decode($email);
    $Client_password = self::HandlePassword(base64_decode($password)); //base64_decode($password);
    $Client_email_captcha = md5(base64_decode($email_captcha));
    $v = false;
    //首先检查邮箱验证码是否正确
    $Client_cache = CacheModel::where('name', '=', $Client_email_captcha)
      ->where('life_time', '>', time())
      ->first() != null;
    //然后检查邮箱是否存在
    $Update_user = self::where('email', '=', $Client_email)->update([
      'password' => $Client_password,
    ]);
    if ($Client_cache && $Update_user == 1) {
      $v = true;
    }
    $data = array(
      'is_reset' => $v,
      // 'update_user' => $Update_user,
      // 'cache' => $Client_cache,
      // 'email' => $Client_email,
      // 'password' => $Client_password,
      // 'email_captcha' => $Client_email_captcha,
    );
    return Share::HandleArrayToJSON($data);
  }
  /**
   * 请求用户信息
   * @param string $token token字符串
   * @return json {is_login:是否登录成功,user:用户信息}
   */
  public static function API_UserUseTokenLogin($token)
  {
    $v = false;
    $Client_user_id = TokenCollector::GetUserId($token);
    $Update_user = 0;
    $Server_user = null;
    if($Client_user_id!=null){
      $Server_user = self::find($Client_user_id);
      if($Server_user!=null){
        while($Update_user == 0){
          $Update_user = self::find($Client_user_id)->update([
            'last_login_ip' => self::GetClientIP(),
            'last_login_location' => self::GetClientLocation(),
            'last_login_time' => time(),
          ]);
        }
        $Server_user['password'] = ''; //不返回密码
        $v = true;
      }
    }
    $data = array(
      'is_login' => $v,
      'user' => $Server_user,
    );
    $UserGroup = UserGroupModel::find($Server_user->user_group_id);
    // while($UserGroup==null){
    //   $UserGroup = UserGroupModel::find($Server_user->user_group_id);
    // }
    $data['user']['UserGroup'] = $UserGroup!=null?$UserGroup:null;
    return Share::HandleArrayToJSON($data);
  }
  /**
   * 根据user_id请求用户信息
   * @param string $user_id 用户id
   * @return json {is_get:是否获取成功,user:用户信息}
   */
  public static function API_GetUser($user_id,$user_token = '',$is_admin = false)
  {
    $v = false;
    $Client_user = null;
    $Server_user = self::find($user_id);
    if ($Server_user) {
      $v = true;
      $Client_user = $Server_user;
    }
    $data = array(
      'is_get' => $v,
      'user' => $Client_user,
    );
    if(!$is_admin&&$Client_user!=null){
      $data['user']['password'] = ''; //不返回密码
      $data['user']['email'] = ''; //不返回邮箱
    }
    if($user_token!=""&&$Client_user!=null){
      $data['user']['is_follow'] = FollowModel::IsFollow($user_token, 'user', $user_id,true);
    }
    
    return Share::HandleArrayToJSON($data);
  }
  /**
   * 请求用户列表信息 recommended,followees,followers
   * @param string $type 类型
   * @param string $page 页码
   * @param string $user_token token字符串
   * @param string $per_page 每页显示的数量
   * @param string $is_admin 是否是管理员
   * @return json {分页用户信息}
   */
  public static function API_GetUsers($type = 'recommended',$page = 1, $user_token = null,$per_page = 20,$is_admin = false)
  {
    if($per_page > Config::getConfig()['mysqlMaxItemQueryCount']) {
      //return Share::HandleArrayToJSON(Share::CommonPaginationDataPack(false, null, null, 'MaxSqlItemQueryCount'));
      $per_page = Config::getConfig()['mysqlMaxItemQueryCount'];
    }
    if($page < 1) {
      return Share::HandleArrayToJSON(Share::CommonPaginationDataPack(false, null, null, 'PageLessThanOne'));
    }
    $Client_user_token = $user_token;
    $users_data = null;
    $v = false;
    $data = Share::CommonPaginationDataPack(false, null, null, null);
    if($type == 'recommended'){
      $Client_page = $page;
      $Client_per_page = $per_page;
      $Client_users = null;
      $Server_users = self::query()->paginate($Client_per_page, ['*'], 'page', $Client_page);
      if ($Server_users) {
        $v = true;
        $Client_users = $Server_users;
      }
      $users_data = $Client_users->items();
      if(!$is_admin){
        foreach ($users_data as $key => $value) {
          $users_data[$key]['password'] = ''; //不返回密码
          $users_data[$key]['email'] = ''; //不返回邮箱Follow
        }
      }

      if($Client_user_token!=null&&$Client_user_token!=''){
        foreach ($users_data as $key => $value) {
          $users_data[$key]['is_follow'] = FollowModel::IsFollow($Client_user_token, 'user', $value['user_id'],true);
        }
      }

      $previousPageUrl = $Client_users->previousPageUrl();
      $nextPageUrl = $Client_users->nextPageUrl();
      $previousPageUrl = $previousPageUrl!=null?str_replace('/?page=','',$previousPageUrl):null;
      $nextPageUrl = $nextPageUrl!=null?str_replace('/?page=','',$nextPageUrl):null;
      
      $data = Share::CommonPaginationDataPack($v, $users_data, [
        'page' => $Client_users->currentPage(),//当前页码
        'per_page' => $Client_users->perPage(),//每页显示的数量
        'total' => $Client_users->total(),//总共有多少个项目
        'pages' => $Client_users->lastPage(),//总共有多少页
        'previous' => $previousPageUrl,//上一页
        'next' => $nextPageUrl,//下一页
      ]);
    }else if($type == 'followees'){
      $data = FollowModel::GetFolloweesList(TokenCollector::GetUserId($Client_user_token), 'user', $page,$Client_user_token);
    }else if($type == 'followers'){
      $data = FollowModel::GetFollowersList(TokenCollector::GetUserId($Client_user_token), 'user', $page,$Client_user_token);
    }

    if(Config::Dev()){
      $data['dev_client_user_token'] = $Client_user_token;
      //$data['dev_client_user_id'] = $Client_user_id;
    }
    
    return Share::HandleArrayToJSON($data);
  }
  /*重置所有人的头像 仅限开发者使用
   * @return json {is_reset:是否重置成功}
   */
  public static function DEV_API_AllUserAvatarReset()
  {
    if(!Config::Dev()){
      return Share::HandleArrayToJSON(array(
        'is_reset' => false,
      ));
    }
    $users = self::all();
    foreach ($users as $key => $value) {
      $avatar = self::CreateDefaultAvatar($value->username);
      self::find($value->user_id)->update([
        'avatar' => $avatar,
      ]);
    }
    return Share::HandleArrayToJSON(array(
      'is_reset' => true,
    ));
  }
  public static function API_EditInfo($username, $headline, $blog, $company, $location, $bio, $user_token,$edit_target_user_id)
  {
    $v = false;
    $Server_user = null;
    $Server_username = self::where('username', '=', $username)->first();
    if($Server_username){
      if($Server_username->user_id == $edit_target_user_id){
        $Server_username = null;
      }
    }
    
    $is_vaild_user = TokenCollector::IsUserSelf(TokenCollector::GetUserId($user_token),$edit_target_user_id)||UserGroupCollector::IsAdmin($user_token);
    if($is_vaild_user&&$Server_username==null){
      $v = self::find($edit_target_user_id)->update([
        'username' => $username,
        'headline' => $headline,
        'blog' => $blog,
        'company' => $company,
        'location' => $location,
        'bio' => $bio,
        'update_time' => time(),
      ]);
      if($v){
        $Server_user = self::find($edit_target_user_id);
      }
    }

    $data = array(
      'is_edit' => $v,
      'user' => $Server_user,
    );
    $v?$data['user']['password'] = '':''; //不返回密码
    $v?$data['user']['UserGroup'] = UserGroupModel::find($Server_user->user_group_id):'';
    return Share::HandleArrayToJSON($data);
  }
  public static function API_UploadAvatar($user_token,$avatar){
    $v = false;
    $Server_user = null;
    $Server_avatar = null;
    $Server_user_id = TokenCollector::GetUserId($user_token);
    $Server_user = self::find($Server_user_id);
    if($Server_user!=null){
      $Server_avatar = self::UploadAvatar($Server_user_id,$avatar);
      if($Server_avatar!=null){
        $v = self::find($Server_user_id)->update([
          'avatar' => $Server_avatar,
        ]);
      }
    }
    $data = array(
      'is_upload' => $v,
      'user' => $Server_user,
      //'avatar' => $avatar,
    );
    $v?$data['user']['password'] = '':''; //不返回密码
    $v?$data['user']['UserGroup'] = UserGroupModel::find($Server_user->user_group_id):'';
    return Share::HandleArrayToJSON($data);
  }
  public static function API_UploadCover($user_token,$cover){
    $v = false;
    $Server_user = null;
    $Server_cover = null;
    $Server_user_id = TokenCollector::GetUserId($user_token);
    $Server_user = self::find($Server_user_id);
    if($Server_user!=null){
      $Server_cover = self::UploadCover($Server_user_id,$cover);
      if($Server_cover!=null){
        $v = self::find($Server_user_id)->update([
          'cover' => $Server_cover,
        ]);
      }
    }
    $data = array(
      'is_upload' => $v,
      'user' => $Server_user,
      //'avatar' => $avatar,
    );
    $v?$data['user']['password'] = '':''; //不返回密码
    $v?$data['user']['UserGroup'] = UserGroupModel::find($Server_user->user_group_id):'';
    return Share::HandleArrayToJSON($data);
  }
}
