<?php
$arrConfig['conn'] = my_sb_connect($arrConfig);

function my_sb_connect($arrConfig)
{
	global $env;
	$connectionString = $env['SB_CONNECTION_STRING'];
	$arrConfig['pg_conn'] = pg_connect($connectionString); // Create connection
	if (!$arrConfig['pg_conn']) {
		die("Connection failed: " . pg_last_error());
	}
	return $arrConfig['pg_conn'];
}

function my_sb_query($sql, $debug = 0)
{
	global $arrConfig;
	if ($debug)
		echo $sql;

	$result = pg_query($arrConfig['conn'], $sql);

	if (!$result) {
		return 0; // Error in query
	}

	if (pg_num_rows($result) > 0) { // SELECT
		$arrRes = array();
		while ($row = pg_fetch_assoc($result)) {
			$arrRes[] = $row;
		}
		return $arrRes;
	} else {
		switch (pg_affected_rows($result)) {
			case 0:
				return [];
			default:
				if ($lastOid = pg_last_oid($result)) {
					return $lastOid; // Last OID for INSERTs
				}
				return pg_affected_rows($result); // Number of affected rows for DELETE, UPDATE
		}
	}
}
