<?php

namespace MaterialDesignForum\Routes;

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

use MaterialDesignForum\Plugins\Share;
use MaterialDesignForum\Plugins\i18n;
use MaterialDesignForum\Config\Config;
use MaterialDesignForum\Views\View;

class Route
{
  public $value1 = '';
  /**
   * 处理页面 应该由视图处理控制。HandlePage string $content 内容
   */
  public static function HandleRoute()
  {
    $collector = new RouteCollector();
    // $collector->get('/phpMyAdmin4.8.5', function () {
    //   //将phpMyAdmin4.8.5重定向到phpMyAdmin4.8.5/index.php  
    //   header('Location: /phpMyAdmin4.8.5/sql.php');
    // });
    $collector->get('/', function () {
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Index.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Index.WebSubTitle'),
        i18n::t('Message.Pages.Index.WebSubTitle'),
        i18n::t('Message.Pages.Index.WebSubTitle')
      );
    });
    $collector->get('/topics', function () {
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Topics.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Topics.WebSubTitle'),
        i18n::t('Message.Pages.Topics.WebSubTitle'),
        i18n::t('Message.Pages.Topics.WebSubTitle')
      );
    });
    $collector->get('/topics/{topic_id}', function ($topic_id) {
      //return '指定的话题页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Topic.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Topic.WebSubTitle'),
        i18n::t('Message.Pages.Topic.WebSubTitle'),
        i18n::t('Message.Pages.Topic.WebSubTitle')
      );
    });
    $collector->get('/questions', function () {
      //return '提问页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Questions.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Questions.WebSubTitle'),
        i18n::t('Message.Pages.Questions.WebSubTitle'),
        i18n::t('Message.Pages.Questions.WebSubTitle')
      );
    });
    $collector->get('/questions/{question_id}', function ($question_id) {
      //return '指定的提问页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Question.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Question.WebSubTitle'),
        i18n::t('Message.Pages.Question.WebSubTitle'),
        i18n::t('Message.Pages.Question.WebSubTitle')
      );
    });
    $collector->get('/questions/{question_id}/answers/{answer_id}?', function ($question_id, $answer_id = null) {
      if ($answer_id !== null && $answer_id !== '') {
        //return '指定的回答页';
        return Share::HandlePage(
          i18n::i18n()->locale,
          i18n::t('Message.Pages.Question.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle')
        );
      } else {
        //return '指定的提问页';
        return Share::HandlePage(
          i18n::i18n()->locale,
          i18n::t('Message.Pages.Question.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle')
        );
      }
    });
    $collector->get('/articles', function () {
      //return '文章页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Articles.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Articles.WebSubTitle'),
        i18n::t('Message.Pages.Articles.WebSubTitle'),
        i18n::t('Message.Pages.Articles.WebSubTitle')
      );
    });
    $collector->get('/articles/{article_id}', function ($article_id) {
      //return '指定的文章页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Article.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Article.WebSubTitle'),
        i18n::t('Message.Pages.Article.WebSubTitle'),
        i18n::t('Message.Pages.Article.WebSubTitle')
      );
    });
    $collector->get('/users/{user_id}', function ($user_id) {
      //return '指定的用户页';
      // return Share::HandlePage(
      //   i18n::i18n()->locale,
      //   i18n::t('Message.Pages.User.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
      //   i18n::t('Message.Pages.User.WebSubTitle'),
      //   i18n::t('Message.Pages.User.WebSubTitle'),
      //   i18n::t('Message.Pages.User.WebSubTitle')
      // );
      View::$lang = i18n::i18n()->locale;
      return View::User($user_id);
    });
    $collector->get('/users', function () {
      //return '用户页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/notifications', function () {
      //return '通知页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Notifications.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Notifications.WebSubTitle'),
        i18n::t('Message.Pages.Notifications.WebSubTitle'),
        i18n::t('Message.Pages.Notifications.WebSubTitle')
      );
    });
    $collector->get('/admin', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/topics', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/questions', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/answers', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/articles', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/comments', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/replys', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/usergroup', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/users', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/reports', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/admin/options', function () {
      //return '管理面板页';
      return Share::HandlePage(
        i18n::i18n()->locale,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}', function ($lang) {
      $langs = $lang;
      //如果$lang不来自于i18n::i18n()->locale
      if(!i18n::VerificationLanguages($langs)){
        $langs = i18n::i18n()->locale;
      }
      //return '首页';
      return Share::HandlePage($langs, '', '', '', '');
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/topics', function ($lang) {
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Topics.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Topics.WebSubTitle'),
        i18n::t('Message.Pages.Topics.WebSubTitle'),
        i18n::t('Message.Pages.Topics.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/topics/{topic_id}', function ($lang, $topic_id) {
      //return '指定的话题页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Topic.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Topic.WebSubTitle'),
        i18n::t('Message.Pages.Topic.WebSubTitle'),
        i18n::t('Message.Pages.Topic.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/questions', function ($lang) {
      //return '提问页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Questions.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Questions.WebSubTitle'),
        i18n::t('Message.Pages.Questions.WebSubTitle'),
        i18n::t('Message.Pages.Questions.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/questions/{question_id}', function ($lang, $question_id) {
      //return '指定的提问页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Question.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Question.WebSubTitle'),
        i18n::t('Message.Pages.Question.WebSubTitle'),
        i18n::t('Message.Pages.Question.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/questions/{question_id}(/answers/{answer_id})?', function ($lang, $question_id, $answer_id = null) {
      if ($answer_id !== null && $answer_id !== '') {
        //return '指定的回答页';
        return Share::HandlePage(
          $lang,
          i18n::t('Message.Pages.Question.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle')
        );
      } else {
        //return '指定的提问页';
        return Share::HandlePage(
          $lang,
          i18n::t('Message.Pages.Question.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle'),
          i18n::t('Message.Pages.Question.WebSubTitle')
        );
      }
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/articles', function ($lang) {
      //return '文章页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Articles.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Articles.WebSubTitle'),
        i18n::t('Message.Pages.Articles.WebSubTitle'),
        i18n::t('Message.Pages.Articles.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/articles/{article_id}', function ($lang, $article_id) {
      //return '指定的文章页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Article.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Article.WebSubTitle'),
        i18n::t('Message.Pages.Article.WebSubTitle'),
        i18n::t('Message.Pages.Article.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/users/{user_id}', function ($lang, $user_id) {
      //return '指定的用户页';
      // return Share::HandlePage(
      //   $lang,
      //   i18n::t('Message.Pages.User.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
      //   i18n::t('Message.Pages.User.WebSubTitle'),
      //   i18n::t('Message.Pages.User.WebSubTitle'),
      //   i18n::t('Message.Pages.User.WebSubTitle')
      // );
      View::$lang = $lang;

      return View::User($user_id);
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/users', function ($lang) {
      //return '用户页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/notifications', function ($lang) {
      //return '通知页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Notifications.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Notifications.WebSubTitle'),
        i18n::t('Message.Pages.Notifications.WebSubTitle'),
        i18n::t('Message.Pages.Notifications.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/topics', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/questions', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/answers', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/articles', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/comments', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/replys', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/usergroup', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/users', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/reports', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    $collector->get('/{lang:[a-z]{2}_[A-Z]{2}}/admin/options', function ($lang) {
      //return '管理面板页';
      return Share::HandlePage(
        $lang,
        i18n::t('Message.Pages.Users.WebSubTitle'). ' - ' . Config::getConfig()['site_name'],
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle'),
        i18n::t('Message.Pages.Users.WebSubTitle')
      );
    });
    // $collector->get('', function () {
    //   return '404';
    // });
    $collector->get('/images/get/{path}/{size}?',function($path,$size=0){//path:/static/images/xxx.png
      return Share::ImagesGet($path,$size);
    });
    $dispatcher =  new Dispatcher($collector->getData());
    return $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  }
}
