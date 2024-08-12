<?php

namespace MaterialDesignForum\Plugins;

use Illuminate\Support\Arr;
use MaterialDesignForum\Plugins\i18n;
use MaterialDesignForum\Config\Config;
use MaterialDesignForum\Models\Option;

class Share
{
  //public static $site_theme = Option::Get('theme');
  /**
   * share.php
   * 读入index.html
   * @param string $lang 语言
   * @param string $title 标题
   * @param string $description 描述
   * @param string $keywords 关键词
   * @param string $content 内容
   * @return string
   */
  public static function HandlePage($lang, $title, $description, $keywords, $content, $theme = '' /*'MaterialDesign'*/)
  {
    if ($theme == '') {
      $theme = Option::Get('theme');
    } // style="color:transparent;"
    $index_html = file_get_contents('././public/themes/' . $theme . '/index.html');
    if (i18n::VerificationLanguages($lang)) {
      $index_html = str_replace('{lang}', $lang, $index_html);
      $index_html = str_replace('{title}', $title, $index_html);
      $index_html = str_replace('{description}', $description, $index_html);
      $index_html = str_replace('{keywords}', $keywords, $index_html);
      $index_html = str_replace('{content}', '<div style="display:none">' . $content . '</div>', $index_html);
    } else {
      $index_html = str_replace('{lang}', i18n::i18n()->locale, $index_html);
      $index_html = str_replace('{title}', i18n::$null_language, $index_html);
      $index_html = str_replace('{description}', i18n::$null_language, $index_html);
      $index_html = str_replace('{keywords}', i18n::$null_language, $index_html);
      $index_html = str_replace('{content}', '<span>' . i18n::$null_language . '</span><br>' . self::As404Page(), $index_html);
    }
    return $index_html;
  }

  public static function HandleViewContent()
  {
  }

  /**
   * 处理Array数据为JSON
   * @param array $data 数据
   * @return string
   */
  public static function HandleArrayToJSON($data)
  {
    if (Config::Dev()) {
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
      return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
  }
  /**
   * 处理JSON数据为数组
   * @param string $data 数据
   * @return array
   */
  public static function HandleJSONToArray($data)
  {
    if (Config::Dev()) {
      return json_decode($data, true);
    } else {
      return json_decode($data);
    }
  }

  /**
   * 为404页面
   */
  public static function As404Page()
  {
    $text = '';
    foreach (i18n::i18n()->getLocaleList() as $key => $value) {
      //$text .= t()->t('Message.Pages.PageNotFound.Page404', $value);
      $text .= '<span>' . i18n::t('Message.Pages.PageNotFound.Page404', $value) . '</span><br>';
    }
    return $text;
  }
  /**
   * 通用分页数据打包
   * @param bool $is_get 是否成功
   * @param array $data 数据
   * @param array $pagination 分页
   * @param string $message 消息
   * @return array
   */
  public static function CommonPaginationDataPack($is_get = false, $data = null, $pagination = [
    'page' => 1, //当前页码
    'per_page' => 0, //每页显示的数量
    'total' => 0, //总共有多少个项目
    'pages' => 0, //总共有多少页
    'previous' => null, //上一页
    'next' => null, //下一页
  ], $message = null)
  {
    $datas = array(
      'is_get' => $is_get,
      'data' => $data == [] || $data == null ? null : $data,
      'pagination' => $pagination = null ? [
        'page' => 1, //当前页码
        'per_page' => 0, //每页显示的数量
        'total' => 0, //总共有多少个项目
        'pages' => 0, //总共有多少页
        'previous' => null, //上一页
        'next' => null, //下一页
      ] : $pagination,
      'message' => $message
    );
    return $datas;
  }

  /**
   * 从原始请求中获取数据 仅限POST且Content-Type为application/x-www-form-urlencoded
   * @return array
   */
  public static function GetRequestData()
  {
    $data = file_get_contents('php://input');
    // 解码 URL 参数字符串
    $decodedParams = urldecode($data);
    // 将解码后的字符串转换为数组
    $paramsArray = array();
    parse_str($decodedParams, $paramsArray);
    return $paramsArray;
  }

  public static function ImagesGet($path,$size=0){
    $images_path = './.'.base64_decode($path);
    if($size!=0){
      $images_path = str_replace('{size}', $size, $images_path);
    }
    //从本地获取图片，根据图片路径
    $image = file_get_contents($images_path);//假设/static/xxx/xxx/1.jpg是已存在的图片
    header('Content-Type: image/png');//设置头信息
    echo $image;//输出图片
    

  }
  /**
   * 导入PHP文件
   */
  // public static function ImportPHP($path)
  // {
  //   switch ($path) {
  //     case 'plugins/share.php':
  //       return include_once __DIR__ . '/../plugins/share.php';
  //       break;
  //     case 'routes/route.php':
  //       return include_once __DIR__ . '/../routes/route.php';
  //       break;
  //     case 'routes/api.php':
  //       return include_once __DIR__ . '/../routes/api.php';
  //       break;
  //     case 'models/base.class.php':
  //       return include_once __DIR__ . '/../models/base.class.php';
  //       break;
  //     case 'models/user.class.php':
  //       return include_once __DIR__ . '/../models/user.class.php';
  //       break;
  //     case 'models/mail_captcha.class.php':
  //       return include_once __DIR__ . '/../models/mail_captcha.class.php';
  //       break;
  //     case 'models/image_captcha.class.php':
  //       return include_once __DIR__ . '/../models/image_captcha.class.php';
  //       break;
  //     // case 'config/mail_config.php':
  //     //   return include_once __DIR__ . '/../config/mail_config.php';
  //     //   break;
  //     case 'config/config.php':
  //       return include_once __DIR__ . '/../config/config.php';
  //       break;
  //     case 'models/mail/MailFunction.php':
  //       return include_once __DIR__ . '/../models/mail/MailFunction.php';
  //       break;
  //     default:
  //       error_log('ImportPHP: '.$path.' is not found.', 0);
  //       break;
  //   }
  // }
}
