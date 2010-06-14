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
 * Description of mysql
 *
 */
define('OBJECT', 'OBJECT', true);

define('ARRAY_A', 'ARRAY_A', false);

define('ARRAY_N', 'ARRAY_N', false);
class Mysql {

	const CHARSET = 'utf8';
	private $_prefix;

	/**
	 * 实例化的数据库对象
	 * @var Db
	 */
	private static $_instance;
	public function __construct($dbhost, $dbuser, $dbpassword, $dbname) {
		if(!function_exists('mysql_connect'))
		throw new exception("<b>Fatal Error:</b> mysql requires mySQL Lib to be compiled and or linked in to the PHP engine'");
		$this->link = mysql_connect($dbhost, $dbuser, $dbpassword);
		$this->select_db($dbname);
		mysql_query("SET character_set_connection=".self::CHARSET.", character_set_results=".self::CHARSET.", character_set_client=binary", $this->link);
	}

	private function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}

	public function set_prefix($prefix) {
		foreach ( (array) $this->tables as $table )
		$this->$table = $prefix . $table;
	}

	public function prepare($query = null) { // ( $query, *$args )
		if ( is_null( $query ) )
		return;
		$args = func_get_args();
		array_shift($args);
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset($args[0]) && is_array($args[0]) )
		$args = $args[0];
		$query = str_replace("'%s'", '%s', $query); // in case someone mistakenly already singlequoted it
		$query = str_replace('"%s"', '%s', $query); // doublequote unquoting
		$query = str_replace('%s', "'%s'", $query); // quote the strings
		array_walk($args, array(&$this, 'escape_by_ref'));
		return @vsprintf($query, $args);
	}

	function flush() {
		$this->last_result = array();
		$this->col_info = null;
		$this->last_query = null;
	}

	/**
	 * Perform a MySQL database query, using current database connection.
	 *
	 * @param string $query
	 * @return int|false Number of rows affected/selected or false on error
	 */
	public function query($query) {

		// filter the query, if filters are available
		// NOTE: some queries are made before the plugins have been loaded, and thus cannot be filtered with this method
		//
		// initialise return
		$return_val = 0;
		$this->flush();

		// Log how the function was called
		$this->func_call = "\$db->query(\"$query\")";

		// Keep track of the last query for debug..
		$this->last_query = $query;

		// Perform the query via std mysql_query function..
		if ( defined('SAVEQUERIES') && SAVEQUERIES )
		$this->timer_start();

		$this->result = mysql_query($query, $this->link);
		if(mysql_error() <> '' || mysql_errno())
			throw new MysqlException(mysql_errno().mysql_error() . $query);
		++$this->num_queries;

		if ( defined('SAVEQUERIES') && SAVEQUERIES )
		$this->queries[] = array( $query, $this->timer_stop(), $this->get_caller() );

		if ( preg_match("/^\\s*(insert|delete|update|replace|alter) /i",$query) ) {
			$this->rows_affected = mysql_affected_rows($this->link);
			// Take note of the insert_id
			if ( preg_match("/^\\s*(insert|replace) /i",$query) ) {
				$this->insert_id = mysql_insert_id($this->link);
			}
			// Return number of rows affected
			$return_val = $this->rows_affected;
		} else {
			$i = 0;
			while ($i < @mysql_num_fields($this->result)) {
				$this->col_info[$i] = @mysql_fetch_field($this->result);
				$i++;
			}
			$num_rows = 0;
			while ( $row = @mysql_fetch_object($this->result) ) {
				$this->last_result[$num_rows] = $row;
				$num_rows++;
			}

			@mysql_free_result($this->result);

			// Log number of rows the query returned
			$this->num_rows = $num_rows;

			// Return number of rows selected
			$return_val = $this->num_rows;
		}

		return $return_val;
	}

	public function insert($table, $data, $format = null) {
		$formats = $format = (array) $format;
		$fields = array_keys($data);
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty($format) )
			$form = ( $form = array_shift($formats) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
			$form = $this->field_types[$field];
			else
			$form = '%s';
			$formatted_fields[] = $form;
		}
		$sql = "INSERT INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES ('" . implode( "','", $formatted_fields ) . "')";
		return $this->query( $this->prepare( $sql, $data) );
	}

	/**
	 * Update a row in the table
	 *
	 * <code>
	 * update( 'table', array( 'column' => 'foo', 'field' => 1337 ), array( 'ID' => 1 ), array( '%s', '%d' ), array( '%d' ) )
	 * </code>
	 * @return int|false The number of rows updated, or false on error.
	 */
	public function update($table, $data, $where, $format = null, $where_format = null) {
		if ( !is_array( $where ) )
		return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys($data) as $field ) {
			if ( !empty($format) )
			$form = ( $form = array_shift($formats) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
			$form = $this->field_types[$field];
			else
			$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys($where) as $field ) {
			if ( !empty($where_format) )
			$form = ( $form = array_shift($where_formats) ) ? $form : $where_format[0];
			elseif ( isset($this->field_types[$field]) )
			$form = $this->field_types[$field];
			else
			$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, array_merge(array_values($data), array_values($where))) );
	}

	public function get_var($query=null, $x = 0, $y = 0) {
		$this->func_call = "\$db->get_var(\"$query\",$x,$y)";
		if ( $query )
		$this->query($query);

		// Extract var out of cached results based x,y vals
		if ( !empty( $this->last_result[$y] ) ) {
			$values = array_values(get_object_vars($this->last_result[$y]));
		}

		// If there is a value return it else return null
		return isset($values[$x]) ? $values[$x] : null;
	}

	/**
	 * Retrieve one row from the database.
	 *
	 * Executes a SQL query and returns the row from the SQL result.
	 *
	 * @param string|null $query SQL query.
	 * @param string $output (optional) one of ARRAY_A | ARRAY_N | OBJECT constants.  Return an associative array (column => value, ...), a numerically indexed array (0 => value, ...) or an object ( ->column = value ), respectively.
	 * @param int $y (optional) Row to return.  Indexed from 0.
	 * @return mixed Database query result in format specifed by $output
	 */
	public function get_row($query = null, $output = OBJECT, $y = 0) {
		$this->func_call = "\$db->get_row(\"$query\",$output,$y)";
		if ( $query )
		$this->query($query);
		else
		return null;

		if ( !isset($this->last_result[$y]) )
		return null;

		if ( $output == OBJECT ) {
			return $this->last_result[$y] ? $this->last_result[$y] : null;
		} elseif ( $output == ARRAY_A ) {
			return $this->last_result[$y] ? get_object_vars($this->last_result[$y]) : null;
		} elseif ( $output == ARRAY_N ) {
			return $this->last_result[$y] ? array_values(get_object_vars($this->last_result[$y])) : null;
		} else {
			throw new MysqlException(' $db->get_row(string query, output type, int offset) -- 输出类型必须是以下类型中的一个：OBJECT, ARRAY_A, ARRAY_N');
		}
	}

	/**
	 * Retrieve one column from the database.
	 *
	 * Executes a SQL query and returns the column from the SQL result.
	 * If the SQL result contains more than one column, this function returns the column specified.
	 * If $query is null, this function returns the specified column from the previous SQL result.
	 *
	 * @param string|null $query SQL query.  If null, use the result from the previous query.
	 * @param int $x Column to return.  Indexed from 0.
	 * @return array Database query result.  Array indexed from 0 by SQL result row number.
	 */
	public function get_col($query = null , $x = 0) {
		if ( $query )
		$this->query($query);

		$new_array = array();
		// Extract the column values
		for ( $i=0; $i < count($this->last_result); $i++ ) {
			$new_array[$i] = $this->get_var(null, $x, $i);
		}
		return $new_array;
	}

	/**
	 * Retrieve an entire SQL result set from the database (i.e., many rows)
	 *
	 * Executes a SQL query and returns the entire SQL result.
	 *
	 * @param string $query SQL query.
	 * @param string $output (optional) ane of ARRAY_A | ARRAY_N | OBJECT | OBJECT_K constants.  With one of the first three, return an array of rows indexed from 0 by SQL result row number.  Each row is an associative array (column => value, ...), a numerically indexed array (0 => value, ...), or an object. ( ->column = value ), respectively.  With OBJECT_K, return an associative array of row objects keyed by the value of each row's first column's value.  Duplicate keys are discarded.
	 * @return mixed Database query results
	 */
	public function get_results($query = null, $output = OBJECT) {
		$this->func_call = "\$db->get_results(\"$query\", $output)";

		if ( $query )
		$this->query($query);
		else
		return null;

		if ( $output == OBJECT ) {
			// Return an integer-keyed array of row objects
			return $this->last_result;
		} elseif ( $output == OBJECT_K ) {
			// Return an array of row objects with keys from column 1
			// (Duplicates are discarded)
			foreach ( $this->last_result as $row ) {
				$key = array_shift( get_object_vars( $row ) );
				if ( !isset( $new_array[ $key ] ) )
				$new_array[ $key ] = $row;
			}
			return $new_array;
		} elseif ( $output == ARRAY_A || $output == ARRAY_N ) {
			// Return an integer-keyed array of...
			if ( $this->last_result ) {
				$i = 0;
				foreach( (array) $this->last_result as $row ) {
					if ( $output == ARRAY_N ) {
						// ...integer-keyed row arrays
						$new_array[$i] = array_values( get_object_vars( $row ) );
					} else {
						// ...column name-keyed row arrays
						$new_array[$i] = get_object_vars( $row );
					}
					++$i;
				}
				return $new_array;
			}
		}
	}

	private function escape_by_ref(&$string) {
		$string = mysql_real_escape_string( $string, $this->link );
	}
	private function timer_start() {
		$this->time_start = microtime(true);
		return true;
	}

	/**
	 * Stops the debugging timer.
	 * @return int Total time spent on the query, in milliseconds
	 */
	private function timer_stop() {
		$time_total = microtime(true) - $this->time_start;
		return $time_total;
	}

	private function get_caller() {
		// requires PHP 4.3+
		if ( !is_callable('debug_backtrace') )
		return '';

		$bt = debug_backtrace();
		$caller = array();

		$bt = array_reverse( $bt );
		foreach ( (array) $bt as $call ) {
			if ( @$call['class'] == __CLASS__ )
			continue;
			$function = $call['function'];
			if ( isset( $call['class'] ) )
			$function = $call['class'] . "->$function";
			$caller[] = $function;
		}
		$caller = join( ', ', $caller );

		return $caller;
	}
}

class MysqlException extends Exception {

}
