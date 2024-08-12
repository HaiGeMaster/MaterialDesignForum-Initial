<?php namespace MaterialDesignForum\Models;
// namespace App\Classes;
/**
 * HaiGeMaster
 * 2652549974@qq.com
 */
class i18n
{
  // 属性
  public $locale;
  public $fallbackLocale;
  public $messages;
  // 构造方法
  /**
   * @param function $i18n = new i18n('zh_CN','en_US',$localization['messages']) 构造方法
   * @param function $i18n->t('message.xxx') 翻译方法
   * @param string $locale 语言区域标识符号 例如zh_CN
   * @param string $fallbackLocale 回退语言区域标识符号 例如zh_CN
   * @param array $messages 语言包 array('zh_CN'=>array('message'=>array('hello'=>'你好')), 'en_US'=>array('message'=>array('hello'=>'Hello'))
   */
  public function __construct($locale, $fallbackLocale, $messages)
  {
    // 构造函数的逻辑
    $this->locale = $locale;
    $this->fallbackLocale = $fallbackLocale;
    $this->messages = $messages;
  }

  // t方法
  /**
   * @param function $i18n->t('message.hello') 翻译方法
   * @param string $text 待翻译的文本
   * @return string 翻译后的文本
   */
  public function t($text = 'Message.hello', $locale = '')
  {
    if($locale == ''){
      $locale = $this->locale;
    }else{
      //如果$locale不来自getLocaleList则返回原文本
      if(!in_array($locale,$this->getLocaleList())){
        //$locale = $this->fallbackLocale;
        return $text;
      }
    }
    return $this->translateText($text, $locale);
  }

  /**
   * @param string $text 待查找翻译的文本
   * @param string $locale 查找语言标识符
   */
  private function translateText($text, $locale)
  {
    $texts = explode('.', $text);

    $translation = $this->messages[$locale];
    foreach ($texts as $key) {
      if (isset($translation[$key])) {
        $translation = $translation[$key];
      } else {
        if ($this->fallbackLocale !== null) {
          $fallbackTranslation = $this->messages[$this->fallbackLocale];
          if (isset($fallbackTranslation[$key])) {
            $translation = $fallbackTranslation[$key];
          } else {
            return $text;
          }
        } else {
          return $text;
        }
      }
    }

    return $translation;
  }

  /**
   * 获取语言包列表
   * @return array 语言包
   */
  public function getLocaleList()
  {
    $localeList = array();
    foreach ($this->messages as $key => $value) {
     // $localeList[] = $key;
     array_push($localeList,$key);
    }
    return $localeList;
  }

  /**
   * 确定输入的语言是否存在的函数
   * @param string $locale 语言标识符
   * @return boolean
   */
  public function hasLocale($locale)
  {
    return isset($this->messages[$locale]);
  }

  /**
   * 设置语言
   * @param string $locale 语言标识符
   * @return void
   */
  public function setLocale($locale)
  {
    $this->locale = $locale;
  }
}
