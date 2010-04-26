<?php
/**
 * MyBlogAdmin Platform
 *
 * @author     millken<millken@gmail.com>
 * @copyright  Copyright (c) 2010 millken
 * @license    GNU General Public License 2.0
 * @version    $Id$
 */
/** 载入配置支持 */
if (!@include_once 'config.inc.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
include 'class/router.php';
$router = Router::getInstance(); // init router
$router->addRule('/books/:id/:keyname',array('controller' => 'books', 'action' => 'view')); // add simple rule
// add some more rules
$router->init(); // execute router
print_r($router->getController());
print_r($router->getAction());
print_r($router->getParams());
$t = unserialize('a:24:{i:0;a:23:{s:5:"index";a:6:{s:3:"url";s:1:"/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:8:"|^[/]?$|";s:6:"format";s:1:"/";s:6:"params";a:0:{}}s:2:"do";a:6:{s:3:"url";s:22:"/action/[action:alpha]";s:6:"widget";s:9:"Widget_Do";s:6:"action";s:6:"action";s:4:"regx";s:32:"|^/action/([_0-9a-zA-Z-]+)[/]?$|";s:6:"format";s:10:"/action/%s";s:6:"params";a:1:{i:0;s:6:"action";}}s:4:"post";a:6:{s:3:"url";s:24:"/archives/[cid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:26:"|^/archives/([0-9]+)[/]?$|";s:6:"format";s:13:"/archives/%s/";s:6:"params";a:1:{i:0;s:3:"cid";}}s:10:"attachment";a:6:{s:3:"url";s:26:"/attachment/[cid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:28:"|^/attachment/([0-9]+)[/]?$|";s:6:"format";s:15:"/attachment/%s/";s:6:"params";a:1:{i:0;s:3:"cid";}}s:8:"category";a:6:{s:3:"url";s:17:"/category/[slug]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:25:"|^/category/([^/]+)[/]?$|";s:6:"format";s:13:"/category/%s/";s:6:"params";a:1:{i:0;s:4:"slug";}}s:3:"tag";a:6:{s:3:"url";s:12:"/tag/[slug]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:20:"|^/tag/([^/]+)[/]?$|";s:6:"format";s:8:"/tag/%s/";s:6:"params";a:1:{i:0;s:4:"slug";}}s:6:"author";a:6:{s:3:"url";s:22:"/author/[uid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:24:"|^/author/([0-9]+)[/]?$|";s:6:"format";s:11:"/author/%s/";s:6:"params";a:1:{i:0;s:3:"uid";}}s:6:"search";a:6:{s:3:"url";s:19:"/search/[keywords]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:23:"|^/search/([^/]+)[/]?$|";s:6:"format";s:11:"/search/%s/";s:6:"params";a:1:{i:0;s:8:"keywords";}}s:10:"index_page";a:6:{s:3:"url";s:21:"/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:22:"|^/page/([0-9]+)[/]?$|";s:6:"format";s:9:"/page/%s/";s:6:"params";a:1:{i:0;s:4:"page";}}s:13:"category_page";a:6:{s:3:"url";s:32:"/category/[slug]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:34:"|^/category/([^/]+)/([0-9]+)[/]?$|";s:6:"format";s:16:"/category/%s/%s/";s:6:"params";a:2:{i:0;s:4:"slug";i:1;s:4:"page";}}s:8:"tag_page";a:6:{s:3:"url";s:27:"/tag/[slug]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:29:"|^/tag/([^/]+)/([0-9]+)[/]?$|";s:6:"format";s:11:"/tag/%s/%s/";s:6:"params";a:2:{i:0;s:4:"slug";i:1;s:4:"page";}}s:11:"author_page";a:6:{s:3:"url";s:37:"/author/[uid:digital]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:33:"|^/author/([0-9]+)/([0-9]+)[/]?$|";s:6:"format";s:14:"/author/%s/%s/";s:6:"params";a:2:{i:0;s:3:"uid";i:1;s:4:"page";}}s:11:"search_page";a:6:{s:3:"url";s:34:"/search/[keywords]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:32:"|^/search/([^/]+)/([0-9]+)[/]?$|";s:6:"format";s:14:"/search/%s/%s/";s:6:"params";a:2:{i:0;s:8:"keywords";i:1;s:4:"page";}}s:12:"archive_year";a:6:{s:3:"url";s:18:"/[year:digital:4]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:19:"|^/([0-9]{4})[/]?$|";s:6:"format";s:4:"/%s/";s:6:"params";a:1:{i:0;s:4:"year";}}s:13:"archive_month";a:6:{s:3:"url";s:36:"/[year:digital:4]/[month:digital:2]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:30:"|^/([0-9]{4})/([0-9]{2})[/]?$|";s:6:"format";s:7:"/%s/%s/";s:6:"params";a:2:{i:0;s:4:"year";i:1;s:5:"month";}}s:11:"archive_day";a:6:{s:3:"url";s:52:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:41:"|^/([0-9]{4})/([0-9]{2})/([0-9]{2})[/]?$|";s:6:"format";s:10:"/%s/%s/%s/";s:6:"params";a:3:{i:0;s:4:"year";i:1;s:5:"month";i:2;s:3:"day";}}s:17:"archive_year_page";a:6:{s:3:"url";s:38:"/[year:digital:4]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:33:"|^/([0-9]{4})/page/([0-9]+)[/]?$|";s:6:"format";s:12:"/%s/page/%s/";s:6:"params";a:2:{i:0;s:4:"year";i:1;s:4:"page";}}s:18:"archive_month_page";a:6:{s:3:"url";s:56:"/[year:digital:4]/[month:digital:2]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:44:"|^/([0-9]{4})/([0-9]{2})/page/([0-9]+)[/]?$|";s:6:"format";s:15:"/%s/%s/page/%s/";s:6:"params";a:3:{i:0;s:4:"year";i:1;s:5:"month";i:2;s:4:"page";}}s:16:"archive_day_page";a:6:{s:3:"url";s:72:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:55:"|^/([0-9]{4})/([0-9]{2})/([0-9]{2})/page/([0-9]+)[/]?$|";s:6:"format";s:18:"/%s/%s/%s/page/%s/";s:6:"params";a:4:{i:0;s:4:"year";i:1;s:5:"month";i:2;s:3:"day";i:3;s:4:"page";}}s:12:"comment_page";a:6:{s:3:"url";s:53:"[permalink:string]/comment-page-[commentPage:digital]";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:34:"|^(.+)/comment-page-([0-9]+)[/]?$|";s:6:"format";s:18:"%s/comment-page-%s";s:6:"params";a:2:{i:0;s:9:"permalink";i:1;s:11:"commentPage";}}s:4:"feed";a:6:{s:3:"url";s:20:"/feed[feed:string:0]";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:4:"feed";s:4:"regx";s:17:"|^/feed(.*)[/]?$|";s:6:"format";s:7:"/feed%s";s:6:"params";a:1:{i:0;s:4:"feed";}}s:8:"feedback";a:6:{s:3:"url";s:31:"[permalink:string]/[type:alpha]";s:6:"widget";s:15:"Widget_Feedback";s:6:"action";s:6:"action";s:4:"regx";s:29:"|^(.+)/([_0-9a-zA-Z-]+)[/]?$|";s:6:"format";s:5:"%s/%s";s:6:"params";a:2:{i:0;s:9:"permalink";i:1;s:4:"type";}}s:4:"page";a:6:{s:3:"url";s:12:"/[slug].html";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";s:4:"regx";s:22:"|^/([^/]+)\.html[/]?$|";s:6:"format";s:8:"/%s.html";s:6:"params";a:1:{i:0;s:4:"slug";}}}s:5:"index";a:3:{s:3:"url";s:1:"/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:2:"do";a:3:{s:3:"url";s:22:"/action/[action:alpha]";s:6:"widget";s:9:"Widget_Do";s:6:"action";s:6:"action";}s:4:"post";a:3:{s:3:"url";s:24:"/archives/[cid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:10:"attachment";a:3:{s:3:"url";s:26:"/attachment/[cid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:8:"category";a:3:{s:3:"url";s:17:"/category/[slug]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:3:"tag";a:3:{s:3:"url";s:12:"/tag/[slug]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:6:"author";a:3:{s:3:"url";s:22:"/author/[uid:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:6:"search";a:3:{s:3:"url";s:19:"/search/[keywords]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:10:"index_page";a:3:{s:3:"url";s:21:"/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:13:"category_page";a:3:{s:3:"url";s:32:"/category/[slug]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:8:"tag_page";a:3:{s:3:"url";s:27:"/tag/[slug]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:11:"author_page";a:3:{s:3:"url";s:37:"/author/[uid:digital]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:11:"search_page";a:3:{s:3:"url";s:34:"/search/[keywords]/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:12:"archive_year";a:3:{s:3:"url";s:18:"/[year:digital:4]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:13:"archive_month";a:3:{s:3:"url";s:36:"/[year:digital:4]/[month:digital:2]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:11:"archive_day";a:3:{s:3:"url";s:52:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:17:"archive_year_page";a:3:{s:3:"url";s:38:"/[year:digital:4]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:18:"archive_month_page";a:3:{s:3:"url";s:56:"/[year:digital:4]/[month:digital:2]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:16:"archive_day_page";a:3:{s:3:"url";s:72:"/[year:digital:4]/[month:digital:2]/[day:digital:2]/page/[page:digital]/";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:12:"comment_page";a:3:{s:3:"url";s:53:"[permalink:string]/comment-page-[commentPage:digital]";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}s:4:"feed";a:3:{s:3:"url";s:20:"/feed[feed:string:0]";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:4:"feed";}s:8:"feedback";a:3:{s:3:"url";s:31:"[permalink:string]/[type:alpha]";s:6:"widget";s:15:"Widget_Feedback";s:6:"action";s:6:"action";}s:4:"page";a:3:{s:3:"url";s:12:"/[slug].html";s:6:"widget";s:14:"Widget_Archive";s:6:"action";s:6:"render";}}');
print_r($t);