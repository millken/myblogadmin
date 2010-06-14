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
	static protected $error;
	static protected $msg;
	public function __construct() {

	}

	public function init() {
		global $dbconfig;
		self::$db = new Mysql($dbconfig['dbhost'],$dbconfig['dbuser'],$dbconfig['dbpass'],$dbconfig['dbname']);
		self::$db->field_types = array( 'slug' => '%s', 'tid' => '%d', 'count' => '%d',	'uid' => '%d', 'name' => '%s', 'value' => '%s');
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
		self::$error = false;
		self::$msg = _INIT_IS_DONE_;
	}

	public function setTerms($postarr ) {
		$defaults = array(
			'name' => '', 'slug' => '', 'type' => 'category', 'description' => '',
			'count' => 0, 'order' => 0, 'blog_id' => __BLOG_ID__,
		);
		$postarr = Common::parse_args($postarr, $defaults);
		extract($postarr);
		if(empty($name))return self::error(_NAME_IS_EMPTY_);
		if(empty($slug)) $slug = urlencode($name);
		else $slug = urlencode($slug);
		$slug = self::makeSlugByName($slug);
		$blog_id = __BLOG_ID__;
		$data = compact( array_keys($defaults) );
		if (isset($tid)) {
			$where = array( 'tid' => $tid, 'blog_id' => $blog_id );
			return self::$db->update(self::$db->terms, $data, $where );
		}else{

			return self::$db->insert(self::$db->terms, $data );
		}

	}
	public function getTerms($args, $one = false) {
		$defaults = array(
			'tid' => 0, 'slug' => '', 'type' => 'category','sort_order' => 'ASC',
			 'sort_column' => 'tid', 'number' => '', 'offset' => 0, 'blog_id' => __BLOG_ID__,
		);
		$postarr = Common::parse_args($args, $defaults);
		extract($postarr);
		$wheredata = 'blog_id=' . __BLOG_ID__;
		if($tid) {
			$wheredata .= ' AND tid=' . intval($tid);
		}elseif($slug) {
			$wheredata .= ' AND slug=\'' .$slug . '\'';
		}elseif($type) {
			$wheredata .= ' AND type=\'' .$type . '\'';
		}
		$sql = "SELECT * FROM `". self::$db->terms ."` WHERE $wheredata ";
		$sql .= " ORDER BY " . $sort_column . " " . $sort_order ;
		if ( !empty($number) )
			$sql .= ' LIMIT ' . $offset . ',' . $number;
		
		$result = $one ?self::$db->get_row($sql) : self::$db->get_results($sql);
		return $result;
	}

	public function getTerm($args, $filed = null) {
		return self::getTerms($args, true);
	}
	private function error($message) {
			self::$error = true;
			self::$msg = $message;
	}
	public function message() {
		return self::$msg;
	}
	public function iserror() {
		return self::$error;
	}
	private function makeSlugByName($slug) {
		$i = 0;
		$slug1 = $slug;
		do{
			$newslug = $slug1;
			$term = self::getTerms(array('slug' => $newslug));
			$slug1  = $slug . '-' . ++$i;
		}while(isset($term->tid));
		return $newslug;
	}
	public function setContents() {
	}
	public function getContents() {
	}
	public function setOptions($name, $value = '') {
		$oldvalue = self::getOptions($name);
		if(null === $oldvalue) {
			self::$db->insert(self::$db->options, array('name' => $name, 'value' => $value, 'blog_id' => __BLOG_ID__) );
		}elseif($oldvalue !== $value){
			self::$db->update(self::$db->options,array('value' => $value), array('name' => $name, 'blog_id' => __BLOG_ID__));
		}
		self::$cache->clearCache('options-' . __BLOG_ID__, $name);
		return true;
	}
	public function getOptions($name) {
		$alloptions = self::getAllOptions();
		if(isset($alloptions[$name])) return $alloptions[$name];
		$value = self::$cache->get('options-' . __BLOG_ID__, $name, __CACHETIME__);
		if(false !== $value)return $value;
		
		$sql = self::$db->prepare("SELECT value FROM `". self::$db->options ."` WHERE blog_id=%d AND name=%s", __BLOG_ID__, $name);
		$value = self::$db->get_var($sql);
		self::$cache->set('options-' . __BLOG_ID__, $name, $value);
		return $value;
	}
	private function getAllOptions() {
		$alloptions = self::$cache->get('options-' . __BLOG_ID__, 'alloptions', __CACHETIME__);
		if($alloptions)return unserialize($alloptions);
		$options = self::$db->get_results(self::$db->prepare("SELECT name,value FROM `". self::$db->options ."` WHERE blog_id=%d", __BLOG_ID__));
		$optionsArr = array();
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
