<?php

class blog_database_test_connection_manager extends phpbb_database_test_connection_manager
{
	/**
	* Load the phpBB database schema into the database
	*/
	public function load_schema()
	{
		$this->ensure_connected(__METHOD__);

		$directory = dirname(__FILE__) . '/../../docs/schemas/';
		$this->load_schema_from_file($directory);
	}
}
