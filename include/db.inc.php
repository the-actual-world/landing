<?php
$arrConfig['conn'] = my_connect($arrConfig);

function my_connect($arrConfig)
{
	global $arrConfig;
	$arrConfig['mysql_conn'] = new mysqli($arrConfig['servername'], $arrConfig['username'], $arrConfig['password'], $arrConfig['dbname']); // Create connection
	if ($arrConfig['mysql_conn']->connect_error) { // Check connection
		die ("Connection failed: " . $arrConfig['mysql_conn']->connect_error);
	}
	$arrConfig['mysql_conn']->set_charset('utf8');
	return $arrConfig['mysql_conn'];
}

function my_query($sql, $debug = 0)
{
	global $arrConfig;
	if ($debug)
		echo $sql;
	$result = $arrConfig['conn']->query($sql);

	/* SELECT
								 mysqli_result Object
								 (
										 [current_field] => 0
										 [field_count] => 5
										 [lengths] => 
										 [num_rows] => 3
										 [type] => 0
								 )
								 */

	/* UPDATE
								 1: correu tudo bem
								 0: erro na QUERY
								 */

	/* DELETE
								 1: correu tudo bem
								 0: erro na QUERY
								 */

	/* INSERT
								 id: correu tudo bem
								 0: erro na QUERY
								 */

	if (isset ($result->num_rows)) { // SELECT
		$arrRes = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$arrRes[] = $row;
			}
		}
		return $arrRes;
	} else if ($result === TRUE) { // INSERT, DELETE, UPDATE
		if ($last_id = $arrConfig['conn']->insert_id) {
			return $last_id;
		}
		return 1;
	}
	return 0;
}

function my_lang_query($sql, $debug = 0)
{
	// get table from the $sql
	$split = explode(' ', $sql);
	$table = $split[3];
	return my_query($sql . ' INNER JOIN lang_' . $table . ' ON ' . $table . '.id = lang_' . $table . '.id', $debug);
}