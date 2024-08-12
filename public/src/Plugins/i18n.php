<?php

namespace MaterialDesignForum\Plugins;

use MaterialDesignForum\Models\i18n as i18nModel;
use MaterialDesignForum\Config\Config;

class i18n
{
  public static $i18n = null;
  public static $null_language = null;

  private static function Init()
  {
    if (self::$i18n == null) {
      self::$i18n = self::CreateInstance();
      self::$null_language = '404 ' . self::$i18n->locale . ' language is null';
    }
  }
  /**
   * 语言国际化i18n对象
   */
  public static function i18n()
  {
    self::Init();
    return self::$i18n;
  }
  /**
   * 语言国际化t函数
   * @param string $t
   * @param string $l
   * @return string
   */
  public static function t($t = 'Message.hello', $l = '')
  {
    self::Init();
    return self::$i18n->t($t, $l);
  }
  /**
   * 验证语言 仅限于构造实例self::i18n后使用
   * @return string
   */
  public static function VerificationLanguages($lang)
  {
    if (self::i18n()->hasLocale($lang)) {
      return true;
    } else {
      return false;
    }
  }

  private static function CreateInstance()
  {
    $dataFolder = '././src/Language/json/pack/';
    
    //$localization = json_decode(file_get_contents("././src/Language/json/language.json"), true);
    //遍历语言文件夹，获取语言文件，为.json文件
    $localization = array();
    $dir = opendir($dataFolder);
    while (($file = readdir($dir)) !== false) {
      if ($file != '.' && $file != '..') {
        $localization[str_replace('.json', '', $file)] = json_decode(file_get_contents($dataFolder . $file), true);
      }
    }

    $lang = '';

    foreach ($localization as $key => $value) {
      //如果$_SERVER['REQUEST_URI']的部分与$key相同，那么就是$key
      if (strpos($_SERVER['REQUEST_URI'], $key) !== false) {
        $lang = $key;
        break;
      }
    }

    // $lang = explode('/', $_SERVER['REQUEST_URI']);//获取请求中的URL并分割为数组
    // $lang = $lang[1];
    // $lang = str_replace("-", "_", $lang);

    if ($lang == ''||!isset($localization[$lang])) {//如果为空或不来自localization
      $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);//从请求协议中获取语言符号
      $lang = str_replace("-", "_", $lang);
    }
    $lang = str_replace("-", "_", $lang);

    $locale  = isset($localization[$lang]) ? $lang : Config::getConfig()['default_language']||array_keys($localization)[0];
    $fallbackLocale = isset($localization[$lang]) ? $lang : array_keys($localization)[0];
    $i18n = new i18nModel($locale, $fallbackLocale, $localization);
    return $i18n;
  }

  public static function getLocaleList(){
    return self::i18n()->getLocaleList();
  }
}
