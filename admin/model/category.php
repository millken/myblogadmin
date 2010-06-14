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
class AdminCategory extends AdminDo {
	public function __construct() {

	}

	public function view( $args = '' ) {
		$category = Blog::getTerms($args);
		$this->assign('editurl', '/admin/category/edit/');
		$this->assign('category', $category);
	}
	public function edit($args) {
		$category = Blog::getTerm($args);
		if(empty($category))return;
		$category->slug = urldecode($category->slug);
		if(!empty($_POST['name'])) {
			$data = array_merge($_POST,array('tid' => $category->tid));
			$result = Blog::setTerms($data);

		}

		$this->assign('category', $category);
	}
	public function add() {
		if(!empty($_POST)) {
			Blog::setTerms($_POST);
			if(Blog::iserror())
			echo Blog::message();
		}
	}
	//put your code here
}
