<?php namespace MaterialDesignForum\Models;
class ImageCaptcha
{
  public $code;
  public $md5code;
  public $img;
  public $black;
  public $green;
  public $white;
  public function __construct()
  {
    if (!isset($_SESSION) || $_SESSION['ImageCaptchaCode'] == '') {
      session_start();
    }else if(isset($_SESSION['ImageCaptchaCode'])){
      $this->code = $_SESSION['ImageCaptchaCode'];
    }
  }
  public function CreateImgAndCode()
  {
    $this->img = imagecreatetruecolor(60, 30);
    $this->black = imagecolorallocate($this->img, 0x00, 0x00, 0x00);
    $this->green = imagecolorallocate($this->img, 0x00, 0xFF, 0x00);
    $this->white = imagecolorallocate($this->img, 0xFF, 0xFF, 0xFF);
    imagefill($this->img, 0, 0, $this->white);
    $this->code = '';
    $randcodestr = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
    for ($i = 0; $i < 5; $i++) {
      $this->code .= $randcodestr[rand(0, strlen($randcodestr) - 1)];
    }
    $_SESSION['ImageCaptchaCode'] = $this->code;
    $this->md5code = md5($this->code);
    imagestring($this->img, 5, 8, 8, $this->code, $this->black);
    for ($i = 0; $i < 100; $i++) {
      imagesetpixel($this->img, rand(0, 60), rand(0, 30), $this->black);
      imagesetpixel($this->img, rand(0, 60), rand(0, 30), $this->green);
    }
    return array(
      'code' => $this->code,
      'md5code' => $this->md5code, //md5加密后的验证码，用于验证
      //'img' => $this->img
    );
  }
  public function GetCode(): string
  {
    $this->code = $_SESSION['ImageCaptchaCode'];
    return $this->code;
  }
  public function OutputImg()
  {
    //header("content-type: image/png");
    imagepng($this->img);
    imagedestroy($this->img);
  }
  public function CheckCode($code): bool
  {
    if ($code == $_SESSION['ImageCaptchaCode']) {
      $_SESSION['ImageCaptchaCode'] = '';
      session_destroy();
      return true;
    } else {
      return false;
    }
  }
}
