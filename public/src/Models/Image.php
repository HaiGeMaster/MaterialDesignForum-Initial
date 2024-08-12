<?php

namespace MaterialDesignForum\Models;
use Md\MDAvatars;
use Illuminate\Database\Eloquent\Model as Eloquent;
// CREATE TABLE IF NOT EXISTS `image` (
//   `key` varchar(50) NOT NULL COMMENT '图片键名',
//   `filename` varchar(255) NOT NULL COMMENT '原始文件名',
//   `width` int unsigned NOT NULL DEFAULT '0' COMMENT '原始图片宽度',
//   `height` int unsigned NOT NULL DEFAULT '0' COMMENT '原始图片高度',
//   `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
//   `item_type` char(10) DEFAULT NULL COMMENT '关联类型：question、answer、article',
//   `item_id` int NOT NULL DEFAULT '0' COMMENT '关联ID',
//   `user_id` int NOT NULL COMMENT '用户ID'
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
class Image extends Eloquent{
  protected $table = 'image';
  protected $primaryKey = 'key';
  public $timestamps = false;
  protected $fillable = [
    'key',
    'filename',
    'width',
    'height',
    'create_time',
    'item_type',
    'item_id',
    'user_id'
  ];
  
  public static $pathData = [
    'user_avatar' => [
      'path' => 'public/static/upload/user/avatars/',
      'sizeArray' => [
        '512',
        '256',
        '128',
        '64',
        '32'
      ],
    ],
    'user_cover' => [
      'path' => 'public/static/upload/user/covers/',
      'sizeArray' => null,
    ],
    'user_avatar_default' => [
      'path' => 'public/static/upload/user/avatars/default/',
      'sizeArray' => [
        '512',
        '256',
        '128',
        '64',
        '32'
      ],
    ],
  ];

  /**
    * 保存图片
    * @param string $type 图片类型 user_avatar、user_cover
    * @param string $base64data base64数据
    * @param string $user_id 用户id
    * @return string 图片路径token base64 to (user_avatar:imgname-{size}.png,imgname.png) || false
  */
  public static function SaveImage($type,$base64data,$user_id = 'cache'){
    $path = '';
    $sizeArray = null;

    if(isset(self::$pathData[$type])){
      $path = self::$pathData[$type]['path'];
      $sizeArray = self::$pathData[$type]['sizeArray'];
    }else{
      return false;
    }
    
    $img = $base64data;// 获取base64
    $img = str_replace('data:image/png;base64,', '', $img);//获取base64中图片数据
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $bpath = $path . $user_id;

    //先删除$bpath路径下的所有文件
    if (file_exists($bpath)) {
      $files = scandir($bpath);
      foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
          unlink($bpath . '/' . $file);
        }
      }
    }

    $file_name = md5(microtime(true));// 图片名称
    if (!file_exists($bpath)) {
      mkdir($bpath, 0777, true);
    }
    
    $path = $bpath .'/'. $file_name . '.png'; // 图片路径
    $url = '/' . $path;

    $r = file_put_contents($path, $data);// 生成图片
    if (!$r) {
      return false;// 保存失败
    }else{
      if($sizeArray!=null){
        //读取图片，并生成不同分辨率的图片，不使用MDAvatars
        $image = imagecreatefrompng($path);
        foreach ($sizeArray as $size) {
          //需要整体缩放，而不是裁剪
          $new_image = imagecreatetruecolor($size, $size);
          $source_width = imagesx($image); // 获取原始图像的宽度
          $source_height = imagesy($image); // 获取原始图像的高度
          imagecopyresampled($new_image, $image, 0, 0, 0, 0, $size, $size, $source_width, $source_height);
          imagepng($new_image, $bpath .'/'. $file_name . '-' . $size . '.png');
        }
        return base64_encode(str_replace('.png', '-{size}.png', $url));
      }else{
        return base64_encode($url);
      }
    }
  }
  /**
    * 创建用户默认头像
    * @param string $name 用户名
    * @param string $user_id 用户id
    * @return string 图片路径token base64 to imgname-{size}.png
  */
  public static function CreateUserDefaultAvatar($name, $user_id = 'cache')
  {
    $file_name = md5(microtime(true));// 图片名称
    $path = self::$pathData['user_avatar_default']['path'] . $user_id;
    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    }
    $Avatar = new MDAvatars($name, 512);
    $sizeArray = self::$pathData['user_avatar_default']['sizeArray'];
    foreach ($sizeArray as $size) {
      $Avatar->Save($path . '/' . $file_name . '-' . $size . '.png', $size);
    }
    $Avatar->Free();
    return base64_encode('/' . $path . '/' . $file_name . '-{size}.png');
  }
}