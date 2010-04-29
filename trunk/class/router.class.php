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
 * URL Router class
 *
 */
class router {
	static protected $instance;
	static protected $controller;
	static protected $action;
	static protected $params;
	static protected $rules;

	public static function getInstance() {
		if (isset(self::$instance) and (self::$instance instanceof self)) {
			return self::$instance;
		} else {
			self::$instance = new self();
			return self::$instance;
		}
	}

	private static function arrayClean($array) {
		foreach($array as $key => $value) {
			if (strlen($value) == 0) unset($array[$key]);
		}
	}

	private static function ruleMatch($rule, $data) {
		$ruleItems = explode('/',$rule); self::arrayClean(&$ruleItems);
		$dataItems = explode('/',$data); self::arrayClean(&$dataItems);

		if (count($ruleItems) == count($dataItems)) {
			$result = array();

			foreach($ruleItems as $ruleKey => $ruleValue) {
				if (preg_match('/^:[\w]{1,}$/',$ruleValue)) {
					$ruleValue = substr($ruleValue,1);
					$result[$ruleValue] = $dataItems[$ruleKey];
				}
				else {
					if (strcmp($ruleValue,$dataItems[$ruleKey]) != 0) {
						return false;
					}
				}
			}

			if (count($result) > 0) return $result;
			unset($result);
		}
		return false;
	}

	private static function defaultRoutes($url) {
		// process default routes
		$items = explode('/',$url);

		// remove empty blocks
		foreach($items as $key => $value) {
			if (strlen($value) == 0) unset($items[$key]);
		}

		// extract data
		if (count($items)) {
			self::$controller = array_shift($items);
			self::$action = array_shift($items);
			self::$params = $items;
		}
	}

	protected function __construct() {
		self::$rules = array();
	}

	public static function init() {
		$url = self::getUrl();
		$isCustom = false;
		//print_r(self::$rules);
		if (count(self::$rules)) {
			foreach(self::$rules as $ruleKey => $ruleData) {
				$params = self::ruleMatch($ruleKey,$url);
				if ($params) {
					self::$controller = $ruleData['controller'];
					self::$action = $ruleData['action'];
					self::$params = $params;
					$isCustom = true;
					break;
				}
			}
		}

		if (!$isCustom) self::defaultRoutes($url);

		if (!strlen(self::$controller)) self::$controller = 'home';
		if (!strlen(self::$action)) self::$action = 'view';
	}

	public static function addRule($rule, $target) {
		self::$rules[$rule] = $target;
	}

	public static function addRules($rules) {
		self::$rules = $rules;
	}

	public static function getUrl() {
		return str_replace(array('/index.php?','/index.php'),'',$_SERVER['REQUEST_URI']);
	}

	public static function getController() { return self::$controller; }
	public static function getAction() { return self::$action; }
	public static function getParams() { return self::$params; }
	public static function getParam($id) { return self::$params[$id]; }
}
