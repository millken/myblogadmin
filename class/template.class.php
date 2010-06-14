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
 * common of template
 * plugin by yourself
 *
 */
define('TEMPLATE_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
/* plugin path */
define('TEMPLATE_PLUGIN_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'template_plugin' . DIRECTORY_SEPARATOR);

class Template {
	public $ldel = "{";
	public $rdel = "}";
	public $template_dir = './templates/';
	public $compile_dir = './template_c/';
	public $compress = false;
	public $_temp_key = array();
	public $_temp_val = array();
	static $version = '20100508';
	public function __construct() {
		$this->start_time = microtime(true);
	}
    public function __destruct(){
		unset($this->_vars);
	}
	public function assign( $tpl_var, $value = null) {
		if (is_array($tpl_var)) {
			foreach ($tpl_var as $_key => $_val) {
				if ($_key != '') {
					$this->_vars[$_key] = $_val;
				}
			}
		} else {
			if ($tpl_var != '') {
				$this->_vars[$tpl_var] = $value;
			}
		}
	}

	public function fetch( $templatename ) {
		$compilefile = $this->compile_dir . $templatename . '.php';
		$nowtime = $this->getDifftime($templatename);
		if( is_file($compilefile) ) {
			$content = file_get_contents( $compilefile );
			$oldtime = substr($content, 8, strpos($content,"*/") - 8);
			if( intval($oldtime) == $nowtime)
			return $this->_eval($content);
		}else{
			if(false == touch($compilefile))
			throw new Exception ("the compiled file: $compilefile unable writed!");
		}
		$content = $this->fetch_source( $templatename );
		$content = preg_replace(
			array('/\?>/','/<\?([php])/i',"/{$this->ldel}([^\{$this->rdel}\{$this->ldel}\n]*){$this->rdel}/e"),
			array('?&gt','&lt?\1',"\$this->doParse('\\1');"),
			$content );
		//die($content);
		$head = '<?php /*' . $nowtime . '*/if(!defined(\'TEMPLATE_DIR\'))exit;?>';
		file_put_contents($compilefile , $head . $content);
		$content = $this->_eval($content);
		return $content;
	}

	public function display( $filename, $output = true ) {
		$content = $this->fetch($filename);
		if($this->compress)
			$content = preg_replace(array("~>\s+\r~","~>\s+\n~","~>\s+<~"),	array(">",">","><"),$content);
		$this->time = sprintf('%.4f', microtime(true) - $this->start_time);
		if($output)die($content);
		return $content;
	}

	protected function _eval( $content ) {
		ob_start();
		eval('?' . '>' . trim($content));
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	protected function doParse( $tag ) {
		$tag = stripslashes(trim($tag));

		if (empty($tag)) {
			return '{}';
		}elseif($tag{0} == '*' && substr($tag, -1) == '*') { // 注释部分
			return '';
		}elseif($tag{0} == '$'){ // variable
			$tags = explode('.',substr($tag,1));
			$var = array_shift($tags);
			$vart = '';
			if(!empty($tags)) $vart = '->' . implode('->', $tags);
			return '<?php echo $this->_vars[\'' . $var . '\']' . $vart . '; ?>';
		}elseif($tag{0} == '/'){ // end tag
			$plug = 'End' . substr($tag, 1) ;
		}else{
			$plug = array_shift(explode(' ', $tag));
		}
		$plugin = self::loadPlugin($plug);
		if(!$plugin)return '{ '. $tag .' }';
		return $plugin->compile($tag);

	}

	private function push_vars($key, $val)    {
		if (!empty($key))
			array_push($this->_temp_key, "\$this->_vars['$key']='" .$this->_vars[$key] . "';");
		if (!empty($val))
			array_push($this->_temp_val, "\$this->_vars['$val']='" .$this->_vars[$val] . "';");
	}

	private function pop_vars() {
		$key = array_pop($this->_temp_key);
		$val = array_pop($this->_temp_val);

		if (!empty($key))eval($key);
	}

	public function fetch_source( $filename ) {
		$file = $this->template_dir . $filename;
		if(is_file( $file )) {
			return file_get_contents( $file );
		}else{
			throw new Exception ('template \'' . $filename . '\'not exists!');
		}
	}

	public function loadPlugin($plugin_name)	{
		$classname = 'Template_Plugin_' . ucfirst(strtolower($plugin_name));
		if (class_exists($classname, false) && method_exists('Template_Plugin','compile'))
		return new $classname;

		$filename = TEMPLATE_PLUGIN_DIR . strtolower($classname) . '.php';
		if(is_file($filename)) {
			include_once ($filename);
			return new $classname;
		}
		return false;
	}
	private function mkdir( $path ) {
		return is_dir($path) or (self::mkdir(dirname($path)) and mkdir($path, 0777));
	}
	private function getDifftime($templatefile) {
		return filemtime($this->template_dir . $templatefile);
	}
	public function setDelimiter($left_delimiter, $right_delimiter) {
		$this->ldel = $left_delimiter;
		$this->rdel = $right_delimiter;
	}
	public function setCompress( $is_compress = false ) {
		$this->compress = $is_compress;
	}
	public function setCompileDir ( $dir, $makedir = false ) {
		if($makedir)self::mkdir($dir);
		$this->compile_dir = $dir;
	}
	public function setTemplateDir( $dir ) {
		if(!is_dir($dir)) throw new Exception ("the directory : $dir not exists!");
		$this->template_dir = $dir . DIRECTORY_SEPARATOR;
	}
}

/*
 * interface for template's plugin
 */
interface Template_Plugin {
	public function compile($tag);
}
class Template_Plugin_Foreach implements Template_Plugin {
	function compile($tag) {
		preg_match_all("/foreach\s+\\$(\w+)\s+as\s+(\\$(\w+)\s*$|\\$(\w+)\s*=>\s*\\$(\w+)$)/i", $tag, $var );
		//print_r($var);
		$key = $val = $output = '';
		if( $var[3][0] ) {
			$key = trim( $var[3][0] );
			$as = '$this->_vars[\''. $key .'\']';
		}elseif( $var[4][0] && $var[5][0] ) {
			$key = trim( $var[4][0] );
			$val = trim( $var[5][0] );
			$as = '$this->_vars[\'' . $key . '\'] => $this->_vars[\'' . $val . '\']';
		}
		$output = '<?php $this->push_vars(\'' . $key .'\', \''. $val .'\'); foreach((array)$this->_vars[\''.$var[1][0].'\'] as '. $as .'){ ?>';
		return $output;
	}

}

class Template_plugin_EndForeach implements Template_Plugin {
	function compile($tag) {
		$output = '<?php }$this->pop_vars(); ?>';
		return $output;
	}
}
class Template_Plugin_If implements Template_Plugin {
	function compile($tag) {
		preg_match_all('/\-?\d+[\.\d]+|\'[^\'|\s]*\'|"[^"|\s]*"|[\$\w\.]+|!==|===|==|!=|<>|<<|>>|<=|>=|&&|\|\||\(|\)|,|\!|\^|=|&|<|>|~|\||\%|\+|\-|\/|\*|\@|\S/', $tag, $match);
		$tokens = $match[0];
		//允许使用的函数列表
		$functionlist = array('strtolower','strtoupper','strlen','urldecode','in_array','array_exists','array_keys','array_values');
		unset($tokens[0]);
		for ($i = 1, $count = count($tokens); $i < $count; $i++) {
			$token = &$tokens[$i];
			switch (strtolower($token)) {
				case 'eq':$token = '==';break;
				case 'ne':break;
				case 'neq':$token = '!=';break;
				case 'lt':$token = '<';break;
				case 'le':break;
				case 'lte':$token = '<=';break;
				case 'gt':$token = '>';break;
				case 'ge':break;
				case 'gte':$token = '>=';break;
				case 'and':$token = '&&';break;
				case 'or':$token = '||';break;
				case 'not':$token = '!';break;
				case 'mod':$token = '%';break;
				default:
					if ($token[0] == '$')
						$token = '$this->_vars[\''. substr($token, 1) .'\']';
					elseif(function_exists($token) && !in_array($token, $functionlist))
					throw new Exception('can\'t use function:'.$token.'');
				break;
			}
		}
		return $this->output($tokens);
	}

	function output($tokens) {
		return '<?php if (' . implode(' ', $tokens) . '){ ?>';
	}
}

class Template_Plugin_Elseif extends Template_Plugin_If  {
	function output($tokens) {
		return '<?php }elseif (' . implode(' ', $tokens) . '){ ?>';
	}

}

class Template_plugin_Else implements Template_Plugin {
	function compile($tag) {
		$output = '<?php }else{ ?>';
		return $output;
	}
}
class Template_plugin_EndIf implements Template_Plugin {
	function compile($tag) {
		$output = '<?php } ?>';
		return $output;
	}
}
class Template_Plugin_Include implements Template_Plugin {
	function compile($tag) {
		$file = preg_replace('/include\s*file\=["\']?\s*([a-zA-Z0-9_.\/]+)\s*[\'"]?\s*/is', '\\1', $tag );
		return '<?php echo $this->fetch(' . "'$file'" . '); ?>';
	}
}