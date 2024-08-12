<?php

namespace MaterialDesignForum\Models;

class FS
{
  public static $cache_dir = 'src/Cache/';
  /**
   * 写出文件
   * @param string $path 路径
   * @param string $content 内容
   */
  public static function Write($path, $content)
  {
    $dir = self::$cache_dir . date('Y-m-d');
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }

    file_put_contents($dir . '/' . $path, $content);

    //删除前一天的文件夹
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $yesterday_dir = self::$cache_dir . $yesterday;
    if (is_dir($yesterday_dir)) {
      self::DelDir($yesterday_dir);
    }
  }
  /**
   * 删除文件夹
   * @param string $dir 文件夹路径
   */
  public static function DelDir($dir)
  {
    if (!is_dir($dir)) {
      return;
    }

    $files = scandir($dir);
    foreach ($files as $file) {
      if ($file === '.' || $file === '..') {
        continue;
      }

      $filePath = $dir . '/' . $file;
      if (is_dir($filePath)) {
        self::DelDir($filePath);
      } else {
        unlink($filePath);
      }
    }

    rmdir($dir);
  }
  /**
   * 查找文件
   * @param string $name 文件名
   * @return string|bool 文件内容
   */
  public static function Find($name)
  {
    $dir = self::$cache_dir . date('Y-m-d');
    if (!is_dir($dir)) {
      return false;
    }

    $files = scandir($dir);
    foreach ($files as $file) {
      if ($file === '.' || $file === '..') {
        continue;
      }

      $filePath = $dir . '/' . $file;
      if (is_dir($filePath)) {
        continue;
      }

      if ($file === $name) {
        $c = file_get_contents($filePath);
        //删除文件
        unlink($filePath);
        return $c;
      }
    }

    return false;
  }
}
