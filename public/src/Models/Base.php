<?php namespace MaterialDesignForum\Models;
use MaterialDesignForum\Config\Config;
class Base{
  /**
   * 表前缀
   */
  public $Prefix = '';//'mate_';//你可以修改！。
  /**
   * @var object 数据库连接
   */
  public $MySQL;
  /**
   * 构造函数
   * @param string $FormName 结构表名
   */
  public function __construct() {//($FormName = 'all') {
    $config = Config::getConfig();//ImportPHP('config/config.php');
    $this->MySQL = mysqli_connect(
      $config['mysqlHostname'], 
      $config['mysqlUsername'], 
      $config['mysqlPassword'], 
      $config['mysqlDatabase']
    );
    if(!$this->MySQL&&$config['webDev']){
      return 'MySQL Connect Error';
    }else{
      mysqli_query($this->MySQL, "set names 'utf8'");
    }
  }
  /**
   * 析构函数
   */
  public function __destruct(){
    mysqli_close($this->MySQL);
  }

}
