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
error_reporting(E_ALL);
if (!include 'config.inc.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
include 'define.inc.php';
include 'class/common.class.php';
$t = new Common();
$t->init();
$router = Router::getInstance(); // init router
$is_Admin = (strpos($_SERVER['REQUEST_URI'], 'admin/'))? true : false;
$blog = new Blog();
$blog->init();

$rules = $is_Admin? $rules_config['admin'] : $rules_config['user'];

$router->addRules( $rules );
$ismatch = $router->init(); // execute router

if($is_Admin == ($ismatch == true)) {
	$adminAction = $router->getAction();
	$handler = new Admin($router->getController(), $adminAction);
	$handler->$adminAction( $router->getParams() );
	include( __ROOT_DIR__ . '/admin/view/' . $router->getController() . '.php');
	exit();
}

$smarty = new Template();
$smarty->assign('a','Millken');
$smarty->assign('user[1]','中国');
$smarty->assign('array',array('test'=>'aaa','im'=>'bbb'));
//$smarty->setDelimiter('{{', '}}');
$smarty->setCompileDir('./templatec_s/', true);
$smarty->setCompress( false);
$smarty->display('index.tpl');

?>

