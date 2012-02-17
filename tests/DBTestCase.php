<?php

abstract class DBTestCase extends PHPUnit_Extensions_Database_TestCase
{
	protected function getConnection()
	{
		global $dbhost, $dbname, $dbuser, $dbpasswd;

		$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpasswd);
		return $this->createDefaultDBConnection($pdo, $dbname);
	}

	protected function getDBAL()
	{
		global $sql_db;
		global $dbhost, $dbuser, $dbpasswd, $dbname, $dbport;

		$db = new $sql_db();
		$db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, false, defined('PHPBB_DB_NEW_LINK') ? PHPBB_DB_NEW_LINK : false);

		return $db;
	}
}
