<?php
$rules_config['admin'] = array(
	'/admin' => array('controller' => 'home'),
	'/admin/category' => array('controller' => 'category'),
	'/admin/category/:category' => array('controller' => 'category'),
	'/admin/category/:category/page/:page' => array('controller' => 'category'),
	'/admin/setup' => array('controller' => 'setup'),

);
$rules_config['user'] = array(
	'/:category' => array('controller' => 'category'),
	'/:category/page/:page' => array('controller' => 'category'),

	'/page/:page' => '' ,
	'/:year/:month/:day/:slug' => '',
	'/feed/' => array('controller' => 'feed'),
	'/tag/:tag' => array('controller' => 'tag'),
	'/search/:keywords' => array('controller' => 'search'),
);

$dbconfig = array(
	'dbhost' => 'localhost',
	'dbuser' => 'root',
	'dbpass' => 'root',
	'dbname' => 'test-blog'
);
