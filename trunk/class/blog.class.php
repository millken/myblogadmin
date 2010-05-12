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
 * Description of blogclass
 *
 */
class Blog {
	static protected $db;
	static protected $cache;
	public function __construct() {

	}

	public function init() {
		global $dbconfig;
		self::$db = new Mysql($dbconfig['dbhost'],$dbconfig['dbuser'],$dbconfig['dbpass'],$dbconfig['dbname']);
		self::$db->field_types = array( 'slug' => '%s', 'tid' => '%d', 'count' => '%d',	'uid' => '%d', name => '%s', value => '%s');
		self::$db->tables = array(
			'terms', 'options',
		);
		$cachename = ucfirst(__CACHE__) . 'CacheDriver';
		//if(defined('__CACHE__') && is_file('cache/' . $cachename . '.class.php')) {
			require_once 'cache/cache.class.php';
			require_once 'cache/'. $cachename . '.class.php';
			self::$cache = new Cache();
			self::$cache->addDriver('file', new $cachename(__ROOT_DIR__ . __DS__ . 'cache' . __DS__));
		//}
		self::$db->set_prefix('tbl_');
	}

	public function setTerms($postarr ) {
		$defaults = array(
			'name' => '', 'slug' => '', 'type' => 'category', 'description' => '',
			'count' => 0, 'order' => 0, 'blog_id' => 0,
		);
		$postarr = Common::parse_args($postarr, $defaults);
		extract($postarr);
		$data = compact( array_keys($defaults) );
		$update = $tid > 0? true : false;
		$where = array( 'tid' => $tid, 'blog_id' => $blog_id );

		if ($update) {
			self::$db->update(self::$db->terms, $data, $where );
		}else{

			self::$db->insert(self::$db->terms, $data );
		}

	}
	public function getTerms($args) {
		$defaults = array(
			'tid' => 0, 'slug' => '', 'type' => 'category', 'blog_id' => 0,
		);
		$postarr = Common::parse_args($args, $defaults);
		extract($postarr);
		if($tid) {
			$wheredata = ' tid=' . intval($tid);
		}elseif($slug) {
			$wheredata = 'slug=\'' .$slug . '\'';
		}elseif($type) {
			$wheredata = 'type=\'' .$type . '\'';
		}
		$wheredata = 'blog_id=' . intval($blog_id);
		$sql = "SELECT * FROM `". self::$db->terms ."` WHERE $wheredata ";
		$result = self::$db->get_results($sql);
		return $result;
	}
	public function setContents() {
	}
	public function getContents() {
	}
	public function setOptions($name, $value = '') {
		self::$db->insert(self::$db->options, array('name' => $name, 'value' => $value, 'blog_id' => __BLOG_ID__) );
	}
	public function getOptions($name) {
		self::getAllOptions();
		$sql = self::$db->prepare("SELECT value FROM `". self::$db->options ."` WHERE blog_id=%d AND name=%s", __BLOG_ID__, $name);
		$result = self::$db->get_var($sql);
		return $result;
	}
	private function getAllOptions() {
		$alloptions = self::$cache->get('options-' . __BLOG_ID__, 'alloptions', __CACHETIME__);
				print_r($alloptions);
		if($alloptions)return $alloptions;
		$options = self::$db->get_results(self::$db->prepare("SELECT name,value FROM `". self::$db->options ."` WHERE blog_id=%d", __BLOG_ID__));

		foreach((array)$options as $option) {
			$optionsArr[$option->name] = $option->value;
		}
		self::$cache->set('options-' . __BLOG_ID__, 'alloptions', serialize($optionsArr));
		return $optionsArr;
	}
	public function setMetas() {
	}
	public function getMetas() {
	}
	public function setUsers() {
	}
	public function getUsers() {
	}
	public function setDomains() {
	}
	public function getDomains() {
	}
	public function setComments() {
	}
	public function getComments() {
	}
}
