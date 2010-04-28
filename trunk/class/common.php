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
 * Description of common
 *
 */
class common {
	function init() {
		function __autoLoad($className)	{
		/**
		 * 自动载入函数并不判断此类的文件是否存在, 我们认为当你显式的调用它时, 你已经确认它存在了
		 * 如果真的无法被加载, 那么系统将出现一个严重错误(Fetal Error)
		 * 如果你需要判断一个类能否被加载, 请使用 Typecho_Common::isAvailableClass 方法
		 */
			@include_once str_replace('_', '/', $className) . '.php';
		}

	/** 兼容php6 */
		if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
			$_GET = self::stripslashesDeep($_GET);
			$_POST = self::stripslashesDeep($_POST);
			$_COOKIE = self::stripslashesDeep($_COOKIE);

			reset($_GET);
			reset($_POST);
			reset($_COOKIE);
		}

		/** 设置异常截获函数 */
		set_exception_handler(array('common', 'exceptionHandle'));
	}
    /**
     * 递归去掉数组反斜线
     *
     * @access public
     * @param mixed $value
     * @return mixed
     */
    public static function stripslashesDeep($value) {
        return is_array($value) ? array_map(array('common', 'stripslashesDeep'), $value) : stripslashes($value);
    }
    /**
     * 异常截获函数
     *
     * @access public
     * @param Exception $exception 截获的异常
     * @return void
     */
    public static function exceptionHandle(Exception $exception) {
        //$obHandles = ob_list_handlers();

        @ob_end_clean();

        /*
        if (in_array('ob_gzhandler', $obHandles)) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }
        */

        if (defined('__DEBUG__') && __DEBUG__) {
            //@ob_clean();
            echo nl2br($exception->__toString());
        } else {
            if (404 == $exception->getCode() && !empty(self::$exceptionHandle)) {
                $handleClass = self::$exceptionHandle;
                new $handleClass($exception);
            } else {
                self::error($exception);
            }
        }

        exit;
    }

    /**
     * 输出错误页面
     *
     * @access public
     * @param mixed $exception 错误信息
     * @return void
     */
    public static function error($exception) {
		$message = $exception->getMessage();
		if ($exception instanceof mysql) {
			//die('error');
		}
		die( $message );
	}
}
