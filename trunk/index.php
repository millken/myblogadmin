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

include 'class/common.php';
common::init();
$router = Router::getInstance(); // init router
$rules_array = array(
	'/:category' => array('controller' => 'category'),
	'/:category/page/:page' => array('controller' => 'category'),

	'/page/:page' => '' ,
	'/:year/:month/:day/:slug' => '',
	'/feed/' => '',
	'/tag/:tag' => array('controller' => 'tag'),
	'/search/:keywords' => array('controller' => 'search'),
);
//$router->addRule('/books/:id/:keyname',array('controller' => 'books', 'action' => 'view')); // add simple rule
$router->addRules( $rules_array );
new mysql('s','s','s','s');
$router->init(); // execute router
//print_r($router->getController());
print_r($router->getAction());
print_r($router->getParams());
