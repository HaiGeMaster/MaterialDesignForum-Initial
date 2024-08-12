-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2023-11-01 00:20:18
-- 服务器版本： 8.0.29
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- 表的结构 `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int unsigned NOT NULL COMMENT '回答ID',
  `question_id` int unsigned NOT NULL COMMENT '问题ID',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `content_markdown` text NOT NULL COMMENT '原始的正文内容',
  `content_rendered` text NOT NULL COMMENT '过滤渲染后的正文内容',
  `comment_count` int unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `vote_count` int NOT NULL DEFAULT '0' COMMENT '投票数，赞成票-反对票，可以为负数',
  `vote_up_count` int NOT NULL DEFAULT '0' COMMENT '赞成票总数',
  `vote_down_count` int NOT NULL DEFAULT '0' COMMENT '反对票总数',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='回答表';

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int unsigned NOT NULL COMMENT '文章ID',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `content_markdown` text COMMENT '原始的正文内容',
  `content_rendered` text COMMENT '过滤渲染后的正文内容',
  `comment_count` int unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `follower_count` int unsigned NOT NULL DEFAULT '0' COMMENT '关注者数量',
  `vote_count` int NOT NULL DEFAULT '0' COMMENT '投票数，赞成票-反对票，可以为负数',
  `vote_up_count` int NOT NULL DEFAULT '0' COMMENT '赞成票总数',
  `vote_down_count` int NOT NULL DEFAULT '0' COMMENT '反对票总数',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='文章表';

-- --------------------------------------------------------

--
-- 表的结构 `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `name` varchar(180) NOT NULL,
  `value` text NOT NULL,
  `create_time` int unsigned DEFAULT NULL COMMENT '创建时间',
  `life_time` int unsigned NOT NULL DEFAULT '0' COMMENT '有效时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='缓存表';

--
-- 转存表中的数据 `cache`
--

INSERT INTO `cache` (`name`, `value`, `create_time`, `life_time`) VALUES
('17bf385b3a973a0bef74986c04d1051d', 'QNZ7q', 1698669132, 1698669432),
('1f56102a03f02974b90ee01a22f2d526', 'W10vX', 1698669111, 1698669411),
('23f0c6478e96c58fb110d83f7842241a', 'PhDiT', 1698669094, 1698669394),
('2e3b3275c995624b69405a835e0a5d4d', '4FiUE', 1698669108, 1698669408),
('30a9ade58499cd033343536b0a047f97', 'e73W4', 1698669102, 1698669402),
('357fe2359cc02e13c6d0a677943ce7e1', 'uhSjD', 1698598020, 1698598320),
('368c4d49fa428d066f80f10975556b02', 'SU5ev', 1698674281, 1698674581),
('49ec77c51439504f5a38a14e7becd043', 'wsNN5', 1698669086, 1698669386),
('605d2e1b220e904070a022b10a508570', 'Ng1HT', 1698669107, 1698669407),
('8fbd1055559dd3681edee2a8e4aa624a', 'SK9tL', 1698599668, 1698599968),
('b220a18ce5183b5165adffbcd9df76e1', '7sR4L', 1698598536, 1698598836);

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int unsigned NOT NULL COMMENT '回答评论ID',
  `commentable_id` int unsigned NOT NULL COMMENT '评论目标的ID',
  `commentable_type` char(10) NOT NULL COMMENT '评论目标类型：article、question、answer、comment 文章、提问、回答、评论',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `content` text NOT NULL COMMENT '原始正文内容',
  `reply_count` int NOT NULL DEFAULT '0' COMMENT '回复数量',
  `vote_count` int NOT NULL DEFAULT '0' COMMENT '投票数，赞成票-反对票，可以为负数',
  `vote_up_count` int NOT NULL DEFAULT '0' COMMENT '赞成票总数',
  `vote_down_count` int NOT NULL DEFAULT '0' COMMENT '反对票总数',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='回答评论表';

-- --------------------------------------------------------

--
-- 表的结构 `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `follow_id` int unsigned NOT NULL COMMENT '关注ID',
  `user_id` int unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `followable_type` char(10) NOT NULL COMMENT '关注目标类型 user、question、article、topic 用户、提问、文章、话题',
  `followable_id` int unsigned NOT NULL COMMENT '关注目标的ID',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '关注时间'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COMMENT='文章关注关系表';

--
-- 转存表中的数据 `follow`
--

INSERT INTO `follow` (`follow_id`, `user_id`, `followable_type`, `followable_id`, `create_time`) VALUES
(1, 1, 'user', 115, 1698605410),
(2, 1, 'user', 116, 1698605411);

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `key` varchar(50) NOT NULL COMMENT '图片键名',
  `filename` varchar(255) NOT NULL COMMENT '原始文件名',
  `width` int unsigned NOT NULL DEFAULT '0' COMMENT '原始图片宽度',
  `height` int unsigned NOT NULL DEFAULT '0' COMMENT '原始图片高度',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `item_type` char(10) DEFAULT NULL COMMENT '关联类型：question、answer、article',
  `item_id` int NOT NULL DEFAULT '0' COMMENT '关联ID',
  `user_id` int NOT NULL COMMENT '用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `inbox_id` int unsigned NOT NULL COMMENT '私信ID',
  `receiver_id` int unsigned NOT NULL COMMENT '接收者ID',
  `sender_id` int unsigned NOT NULL COMMENT '发送者ID',
  `content_markdown` text NOT NULL COMMENT '原始的私信内容',
  `content_rendered` text NOT NULL COMMENT '过滤渲染后的私信内容',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `read_time` int unsigned NOT NULL DEFAULT '0' COMMENT '阅读时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='私信表';

-- --------------------------------------------------------

--
-- 表的结构 `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int unsigned NOT NULL COMMENT '通知ID',
  `receiver_id` int unsigned NOT NULL COMMENT '接收者ID',
  `sender_id` int NOT NULL COMMENT '发送者ID',
  `type` varchar(40) NOT NULL COMMENT '消息类型：\r\nquestion_answered, \r\nquestion_commented, \r\nquestion_deleted, \r\narticle_commented, \r\narticle_deleted, \r\nanswer_commented, \r\nanswer_deleted, \r\ncomment_replied, \r\ncomment_deleted',
  `article_id` int NOT NULL COMMENT '文章ID',
  `question_id` int NOT NULL COMMENT '提问ID',
  `answer_id` int NOT NULL COMMENT '回答ID',
  `comment_id` int NOT NULL COMMENT '评论ID',
  `reply_id` int NOT NULL COMMENT '回复ID',
  `content_deleted` text NOT NULL COMMENT '被删除的内容的备份',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `read_time` int unsigned NOT NULL DEFAULT '0' COMMENT '阅读时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='通知表';

-- --------------------------------------------------------

--
-- 表的结构 `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '字段名',
  `value` text NOT NULL COMMENT '字段值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='设置表';

--
-- 转存表中的数据 `option`
--

INSERT INTO `option` (`name`, `value`) VALUES
('default_language', 'zh_CN'),
('site_description', '基于 Vuetify 的 Material Design 样式的社区'),
('site_gongan_beian', ''),
('site_icp_beian', ''),
('site_keywords', 'Material Design Forum,Vuetify'),
('site_name', 'Material Design Forum'),
('site_static_url', ''),
('smtp_host', 'smtp.qq.com'),
('smtp_password', ''),
('smtp_port', '465'),
('smtp_reply_to', ''),
('smtp_secure', 'ssl'),
('smtp_send_name', 'Material Design Forum'),
('smtp_username', '2652549974@qq.com'),
('theme', 'MaterialDesign');

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int unsigned NOT NULL COMMENT '问题ID',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `content_markdown` text COMMENT '原始的正文内容',
  `content_rendered` text COMMENT '过滤渲染后的正文内容',
  `comment_count` int unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `answer_count` int unsigned NOT NULL DEFAULT '0' COMMENT '回答数量',
  `follower_count` int unsigned NOT NULL DEFAULT '0' COMMENT '关注者数量',
  `vote_count` int NOT NULL DEFAULT '0' COMMENT '投票数，赞成票-反对票，可以为负数',
  `vote_up_count` int NOT NULL DEFAULT '0' COMMENT '赞成票总数',
  `vote_down_count` int NOT NULL DEFAULT '0' COMMENT '反对票总数',
  `last_answer_time` int unsigned NOT NULL DEFAULT '0' COMMENT '最后回答时间',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='问题表';

-- --------------------------------------------------------

--
-- 表的结构 `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `report_id` int unsigned NOT NULL,
  `reportable_id` int unsigned NOT NULL COMMENT '举报目标ID',
  `reportable_type` char(10) NOT NULL COMMENT '举报目标类型：question、article、answer、comment、user',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `reason` varchar(200) NOT NULL COMMENT '举报原因',
  `create_time` int unsigned NOT NULL COMMENT '举报时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='举报';

-- --------------------------------------------------------

--
-- 表的结构 `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `token` varchar(50) NOT NULL DEFAULT '' COMMENT 'token 字符串',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `device` varchar(600) NOT NULL DEFAULT '' COMMENT '登陆设备，浏览器 UA 等信息',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `expire_time` int unsigned NOT NULL DEFAULT '0' COMMENT '过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='用户TOKEN';

--
-- 转存表中的数据 `token`
--

INSERT INTO `token` (`token`, `user_id`, `device`, `create_time`, `update_time`, `expire_time`) VALUES
('09c2f1e944d3329a6cfe3c1db6237513', 1, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Mobile Safari/537.36 EdgA/118.0.2088.58', 1698402546, 1698726840, 1699331640),
('a20aba2928e07b29b03c0a86a0285143', 116, 'Mozilla/5.0 (Linux; Android 11; Pixel 5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.91 Mobile Safari/537.36', 1698598126, 1698598217, 1699203017),
('f4811272542e3976805c1b8875426585', 115, 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 QQ/8.9.85.608 V1_IPH_SQ_8.9.85_1_APP_A Pixel/1179 MiniAppEnable SimpleUISwitch/0 StudyMode/0 CurrentMode/0 CurrentFontScale/1.000000 QQTheme/1102 AppId/537179600 Core/WKWebView Device/Apple(iPhone 14 Pro) NetType/5G QBWebViewType/1 WKType/1', 1698597683, 1698597683, 1699202483);

-- --------------------------------------------------------

--
-- 表的结构 `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topic_id` int unsigned NOT NULL COMMENT '话题ID',
  `user_id` int NOT NULL COMMENT '话题创建者用户id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '话题名称',
  `cover` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL COMMENT '封面图片token',
  `description` varchar(1000) NOT NULL DEFAULT '' COMMENT '话题描述',
  `article_count` int unsigned NOT NULL DEFAULT '0' COMMENT '文章数量',
  `question_count` int unsigned NOT NULL DEFAULT '0' COMMENT '问题数量',
  `follower_count` int unsigned NOT NULL DEFAULT '0' COMMENT '关注者数量',
  `delete_time` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='话题表';

-- --------------------------------------------------------

--
-- 表的结构 `topicable`
--

CREATE TABLE IF NOT EXISTS `topicable` (
  `topic_id` int unsigned NOT NULL COMMENT '话题ID',
  `topicable_id` int unsigned NOT NULL COMMENT '话题关系对应的ID',
  `topicable_type` char(10) NOT NULL COMMENT '话题关系对应的类型 question、article',
  `create_time` int unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `user_group_id` int unsigned NOT NULL DEFAULT '2' COMMENT '用户组ID',
  `username` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `email` varchar(320) NOT NULL COMMENT '邮箱',
  `avatar` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL COMMENT '头像token',
  `cover` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL COMMENT '封面图片token',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `create_ip` varchar(80) DEFAULT NULL COMMENT '注册IP',
  `create_location` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL COMMENT '注册地址',
  `last_login_time` int unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(80) DEFAULT NULL COMMENT '最后登陆IP',
  `last_login_location` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT NULL COMMENT '最后登录地址',
  `follower_count` int unsigned NOT NULL DEFAULT '0' COMMENT '关注我的人数',
  `followee_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我关注的人数',
  `following_article_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我关注的文章数',
  `following_question_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我关注的问题数',
  `following_topic_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我关注的话题数',
  `article_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我发表的文章数量',
  `question_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我发表的问题数量',
  `answer_count` int unsigned NOT NULL DEFAULT '0' COMMENT '我发表的回答数量',
  `notification_unread` int unsigned NOT NULL DEFAULT '0' COMMENT '未读通知数',
  `inbox_system` int unsigned NOT NULL DEFAULT '0' COMMENT '未读系统信息数',
  `inbox_user_group` int unsigned NOT NULL DEFAULT '0' COMMENT '未读用户组信息数',
  `inbox_private_message` int unsigned NOT NULL DEFAULT '0' COMMENT '未读私信数',
  `headline` varchar(40) DEFAULT NULL COMMENT '一句话介绍',
  `bio` varchar(160) DEFAULT NULL COMMENT '个人简介',
  `blog` varchar(255) DEFAULT NULL COMMENT '个人主页',
  `company` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `location` varchar(255) DEFAULT NULL COMMENT '地址',
  `create_time` int unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_time` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `disable_time` int unsigned NOT NULL DEFAULT '0' COMMENT '禁用时间'
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb3 COMMENT='用户表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_group_id`, `username`, `email`, `avatar`, `cover`, `password`, `create_ip`, `create_location`, `last_login_time`, `last_login_ip`, `last_login_location`, `follower_count`, `followee_count`, `following_article_count`, `following_question_count`, `following_topic_count`, `article_count`, `question_count`, `answer_count`, `notification_unread`, `inbox_system`, `inbox_user_group`, `inbox_private_message`, `headline`, `bio`, `blog`, `company`, `location`, `create_time`, `update_time`, `disable_time`) VALUES
(1, 1, 'MaterialDesignForum', 'materialdesignforum@xbedrock.com', 'L3B1YmxpYy9zdGF0aWMvdXBsb2FkL3VzZXIvYXZhdGFycy8xL2Y4ZWU2ZGIxYjY0ZTk1NDU1OTQzODNjZmFhMGI4ODAyLXtzaXplfS5wbmc=', 'L3B1YmxpYy9zdGF0aWMvdXBsb2FkL3VzZXIvY292ZXJzLzEvYjZiY2RmYTg3OGU4OTRiNzdlZWY0YWEyZDFkMGJhMzEucG5n', '81dc9bdb52d04dc20036dbd8313ed055', '127.0.0.1', '本机地址 本机地址', 1698766941, '112.96.64.157', '中国 广东   联通', 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '本账号密码1234', '', '', '岭南师范学院', '中国 广东 韶关 全球边缘网络', 1694423269, 1698605395, 0),
(115, 2, 'YuanMoe', 'admin@yuan.moe', 'L3B1YmxpYy9zdGF0aWMvdXBsb2FkL3VzZXIvYXZhdGFycy9jYWNoZS84ODhjZmI1NGY0ZjRkMzVhODA2M2Q4NWViNTVmZTRmMi17c2l6ZX0ucG5n', NULL, 'd8d317b0f35f80be81e2b45dd1dc6408', '2400:6180:0:d0::57:4001', '新加坡    ', 1698597684, '2400:6180:0:d0::57:4001', '新加坡    ', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, '新加坡    ', 1698597668, 1698597668, 0),
(116, 2, 'qwert', '18939652976@163.com', 'L3B1YmxpYy9zdGF0aWMvdXBsb2FkL3VzZXIvYXZhdGFycy9jYWNoZS85ZDM0NzQyNjdlMDJiODI5NGUzYmE2OGUyNWRjMzQ5My17c2l6ZX0ucG5n', NULL, '5de81259083d2bf7ccae5720724d3cca', '115.171.57.247', '中国 北京   电信', 1698598219, '115.171.57.247', '中国 北京   电信', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, '中国 北京   电信', 1698598107, 1698598107, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_group_id` int unsigned NOT NULL COMMENT '用户组ID',
  `user_group_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL DEFAULT 'User' COMMENT '用户组名称',
  `user_group_description` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL DEFAULT 'User' COMMENT '用户组描述',
  `user_group_icon` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT 'mdi-account' COMMENT '用户组图标',
  `user_group_color` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT '' COMMENT '用户组颜色',
  `user_group_user_count` int unsigned NOT NULL DEFAULT '0' COMMENT '用户组人数',
  `ability_normal_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '前台正常登录',
  `ability_admin_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台登录',
  `ability_admin_manage_user_group` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理用户组（真则显示）',
  `ability_admin_manage_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理用户（真则显示）',
  `ability_admin_manage_topic` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8_general_ci DEFAULT 'false' COMMENT '是否可后台管理话题（真则显示）',
  `ability_admin_manage_question` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理问题（真则显示）',
  `ability_admin_manage_article` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理文章（真则显示）',
  `ability_admin_manage_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理评论（真则显示）',
  `ability_admin_manage_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理回答（真则显示）',
  `ability_admin_manage_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理回复（真则显示）',
  `ability_admin_manage_report` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可后台管理举报（真则显示）',
  `ability_create_article` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可发表文章',
  `ability_create_question` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可发表问题',
  `ability_create_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可发表回答',
  `ability_create_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可发表评论',
  `ability_create_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可发表回复',
  `ability_create_topic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可创建话题',
  `ability_edit_own_article` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可编辑自己的文章',
  `ability_edit_own_question` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可编辑自己的问题',
  `ability_edit_own_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可编辑自己的回答',
  `ability_edit_own_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可编辑自己的评论',
  `ability_edit_own_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可编辑自己的回复',
  `ability_edit_own_topic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可编辑自己的话题',
  `ability_delete_own_article` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除自己的文章',
  `ability_delete_own_question` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除自己的问题',
  `ability_delete_own_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除自己的回答',
  `ability_delete_own_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除自己的评论',
  `ability_delete_own_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除自己的回复',
  `ability_delete_own_topic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可删除自己的话题',
  `time_before_edit_article` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可编辑自己的文章（单位：分钟，0无限期）',
  `time_before_edit_question` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可编辑自己的问题（单位：分钟，0无限期）',
  `time_before_edit_answer` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可编辑自己的回答（单位：分钟，0无限期）',
  `time_before_edit_comment` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可编辑自己的评论（单位：分钟，0无限期）',
  `time_before_edit_reply` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可编辑自己的回复（单位：分钟，0无限期）',
  `time_before_edit_topic` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可编辑自己的话题（单位：分钟，0无限期）',
  `time_before_delete_article` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可删除自己的文章（单位：分钟，0无限期）',
  `time_before_delete_question` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可删除自己的问题（单位：分钟，0无限期）',
  `time_before_delete_answer` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可删除自己的回答（单位：分钟，0无限期）',
  `time_before_delete_comment` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可删除自己的评论（单位：分钟，0无限期）',
  `time_before_delete_reply` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可删除自己的回复（单位：分钟，0无限期）',
  `time_before_delete_topic` int unsigned NOT NULL DEFAULT '5' COMMENT '在多长时间前可删除自己的话题（单位：分钟，0无限期）',
  `ability_edit_article_only_no_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限文章没有评论的情况下才能编辑',
  `ability_edit_question_only_no_answer` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限问题没有回答的情况下才能编辑',
  `ability_edit_answer_only_no_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限回答没有评论的情况下才能编辑',
  `ability_edit_question_only_no_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限问题没有评论的情况下才能编辑',
  `ability_edit_comment_only_no_reply` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限评论没有回复的情况下才能编辑',
  `ability_edit_topic_only_no_article_or_question` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限话题没有文章或问题的情况下才能编辑',
  `ability_delete_article_only_no_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限文章没有评论的情况下才能删除',
  `ability_delete_question_only_no_answer` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限问题没有回答的情况下才能删除',
  `ability_delete_answer_only_no_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限回答没有评论的情况下才能删除',
  `ability_delete_question_only_no_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限问题没有评论的情况下才能删除',
  `ability_delete_comment_only_no_reply` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限评论没有回复的情况下才能删除',
  `ability_delete_topic_only_no_article_or_question` tinyint(1) NOT NULL DEFAULT '1' COMMENT '仅限话题没有文章或问题的情况下才能删除',
  `ability_edit_own_info` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可编辑自己的个人信息'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT COMMENT='用户组表';

--
-- 转存表中的数据 `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_icon`, `user_group_color`, `user_group_user_count`, `ability_normal_login`, `ability_admin_login`, `ability_admin_manage_user_group`, `ability_admin_manage_user`, `ability_admin_manage_topic`, `ability_admin_manage_question`, `ability_admin_manage_article`, `ability_admin_manage_comment`, `ability_admin_manage_answer`, `ability_admin_manage_reply`, `ability_admin_manage_report`, `ability_create_article`, `ability_create_question`, `ability_create_answer`, `ability_create_comment`, `ability_create_reply`, `ability_create_topic`, `ability_edit_own_article`, `ability_edit_own_question`, `ability_edit_own_answer`, `ability_edit_own_comment`, `ability_edit_own_reply`, `ability_edit_own_topic`, `ability_delete_own_article`, `ability_delete_own_question`, `ability_delete_own_answer`, `ability_delete_own_comment`, `ability_delete_own_reply`, `ability_delete_own_topic`, `time_before_edit_article`, `time_before_edit_question`, `time_before_edit_answer`, `time_before_edit_comment`, `time_before_edit_reply`, `time_before_edit_topic`, `time_before_delete_article`, `time_before_delete_question`, `time_before_delete_answer`, `time_before_delete_comment`, `time_before_delete_reply`, `time_before_delete_topic`, `ability_edit_article_only_no_comment`, `ability_edit_question_only_no_answer`, `ability_edit_answer_only_no_comment`, `ability_edit_question_only_no_comment`, `ability_edit_comment_only_no_reply`, `ability_edit_topic_only_no_article_or_question`, `ability_delete_article_only_no_comment`, `ability_delete_question_only_no_answer`, `ability_delete_answer_only_no_comment`, `ability_delete_question_only_no_comment`, `ability_delete_comment_only_no_reply`, `ability_delete_topic_only_no_article_or_question`, `ability_edit_own_info`) VALUES
(1, 'Admin', 'Admin', 'mdi-account-check', NULL, 0, 1, 1, 1, 1, '1', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 'User', 'User', 'mdi-account', NULL, 2, 1, 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `votable_id` int unsigned NOT NULL COMMENT '投票目标ID',
  `votable_type` char(10) NOT NULL COMMENT '投票目标类型 question、answer、article、comment',
  `type` char(10) NOT NULL COMMENT '投票类型 up、down',
  `create_time` int unsigned NOT NULL COMMENT '投票时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`inbox_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '回答ID';
--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `article_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID';
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '回答评论ID';
--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `follow_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '关注ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '问题ID';
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '话题ID';
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `user_group_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
