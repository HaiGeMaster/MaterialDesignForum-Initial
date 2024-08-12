<?php namespace MaterialDesignForum\Views;
use MaterialDesignForum\Plugins\Share;
use MaterialDesignForum\Plugins\i18n;
use MaterialDesignForum\Models\Option;

class View{
  public static $lang;//语言 从外部设置
  public static $title;
  public static $description;
  public static $keywords;
  public static $content;
  public static function Home(){
    
  }

  public static function Topics(){
    return self::ReturnView();
  }

  public static function Topic(){
    return self::ReturnView();
  }

  public static function Questions(){
    return self::ReturnView();
  }

  public static function Question(){
    return self::ReturnView();
  }

  public static function Question_And_Answers(){
    return self::ReturnView();
  }

  public static function Articles(){
    return self::ReturnView();
  }

  public static function Article(){
    return self::ReturnView();
  }

  public static function User($user_id){
    $dataJSON = \MaterialDesignForum\Collectors\Api\User::GetUser($user_id);
    $dataArray = Share::HandleJSONToArray(
      $dataJSON
    );

    $link = '<ul>';
    //$i18nList = i18n::getLocaleList();
    $linkhead = '';
    $linkend = "/users/".$dataArray['user_id'];
    $link .= '<li><a href="'.$linkhead.$linkend.'">'.str_replace("%s",$dataArray['username'],i18n::t('Message.Pages.User.NPersonalHomepage')).'</a></li>';
    foreach(i18n::getLocaleList() as $v){
      $link .= '<li><a href="'.$linkhead.'/'.$v.$linkend.'">'.str_replace("%s",$dataArray['username'],i18n::t('Message.Pages.User.NPersonalHomepage',$v)).'</a></li>';
    }
    $link .= '</ul>';

    self::$title = str_replace(
      "%s",$dataArray['username'],i18n::t('Message.Pages.User.NPersonalHomepage')
      ).' - '.Option::Get('site_name');
    self::$description = 
      Option::Get('site_name').' - '.Option::Get('site_description')
    ;
    self::$keywords = 
      self::$title.','.Option::Get('site_keywords')
    ;
    self::$content = $dataJSON. $link;
    return self::ReturnView();
  }

  public static function Users(){
    return self::ReturnView();
  }

  private static function ReturnView(){
    return Share::HandlePage(
      self::$lang,
      self::$title,
      self::$description,
      self::$keywords,
      self::$content
    );
  }
}

  
//返回格式必须为数组

?>