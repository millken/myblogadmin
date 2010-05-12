<?php
/**
 * MyBlogAdmin Blog Platform
 *
 * @author     millken<millken@gmail.com>
 * @copyright  Copyright (c) 2010 MyBlogAdmin
 * @license    GNU General Public License 2.0
 * @version    $Id$
 */
/**
 * Description of home
 *
 */
class AdminHome {
	public function __construct() {
		$this->start_time = microtime(true);
	}

	public function view( $args ) {
		print_r($args);
		echo 'hello!@';
	}
	//put your code here
}
