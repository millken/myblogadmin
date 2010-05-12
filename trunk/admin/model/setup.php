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
class AdminSetup {
	public function __construct() {
		$this->start_time = microtime(true);
	}

	public function view( $args ) {
		echo Blog::getOptions('title');
		if(!empty($_POST)) {
			$defaults = array('title' ,'subtitle' ,'blognotice' ,'domain' ,'baseurl' ,'feedurl' ,'timedelta' ,'theme_name' ,
				'posts_per_page' ,'comments_order' ,'comments_per_page' ,'comment_notify_mail' ,'rpcuser' ,'rpcpassword' ,
				'action' ,'str_options' ,'bool_options' ,'int_options' ,'float_options'
			);
			foreach($defaults as $d) {
				Blog::setOptions($d, $_POST[$d]);
				}
			print_r($_POST);
		}
	}
	//put your code here
}
