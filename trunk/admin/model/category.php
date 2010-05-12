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
class AdminCategory {
	public function __construct() {
	}

	public function view( $args ) {
		Blog::getTerms($args);
	}
	//put your code here
}
