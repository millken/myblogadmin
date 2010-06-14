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
 * Description of admin
 *
 */
class Admin {
	private $adapter_instance;
	static protected $name;
	static protected $action;

	
	public function __construct($name = '', $action = '') {
		self::$name = ucfirst($name);
		//if (is_callable(array( $name, $action )))
		$this->setAdapter(self::$name, $action);
		//throw new Exception('' . $name . '::' . $action . ' not exists!');

	}

	public function setAdapter($name = '',  $action = '') {
		$class_name = 'Admin' . ucwords($name);
		$class_path = __ROOT_DIR__ . __DS__ . 'admin' . __DS__  . 'model' . __DS__ . $name. '.php';
		if (FALSE == @file_exists($class_path)) throw new AdminException(sprintf('The adapter was not existed: %s', $name));
		include_once($class_path);
		if (FALSE == class_exists($class_name, FALSE)) throw new AdminException(sprintf('The adapter could not be loaded: %s', $name));
		$this->adapter_instance = new $class_name();
		if (FALSE == method_exists($this->adapter_instance, $action)) throw new AdminException(sprintf('The action\' %s \' not found in : %s',$action, $name));
		self::$action = $action;
		return $this->adapter_instance;
	}

    public function __set($nm, $val)
    {
        echo "Setting [$nm] to $val\n";

        if (isset($this->x[$nm])) {
            $this->x[$nm] = $val;
            echo "OK!\n";
        } else {
            echo "Not OK!\n";
        }
    }
	/**
	 * Magic: 方法调用
	 *
	 * @param 字符串 $method_name
	 * @param 数组 $method_args
	 **/
	public function __call($method_name, $method_args) {

		if (TRUE == method_exists($this, $method_name))
			return call_user_func_array(array(& $this, $method_name), $method_args);
		elseif (
			FALSE == empty($this->adapter_instance)
			&& TRUE == method_exists($this->adapter_instance, $method_name)
		) return call_user_func_array(array(& $this->adapter_instance, $method_name), $method_args);
		else throw new AdminException(sprintf('Tryied to call unknown method: %s', $method_name));
	}
}

class AdminDo {
	public $smarty;
	public function __construct(){
		$this->initTemplate();
	}

	public function initTemplate($action) {
		$this->smarty = new Template();
		$this->smarty->setTemplateDir( __ROOT_DIR__ . __DS__ . 'templates' . __DS__ . 'admin.default');
		$this->smarty->setCompileDir('./templatec_s/', true);
		$this->assign('action', $action);
	}

	public function assign( $tpl_var, $value = null) {

		return $this->smarty->assign($tpl_var, $value);
	}

	public function display($filename) {
		return $this->smarty->display($filename);
	}
}
class AdminException extends Exception{
}
