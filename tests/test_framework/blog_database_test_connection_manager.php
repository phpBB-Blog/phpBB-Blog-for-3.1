<?php

class blog_database_test_connection_manager extends phpbb_database_test_connection_manager
{
	/**
	* Creates a PDO connection for the configured database.
	*
	* @param	bool	$use_db		Whether the DSN should be tied to a
	*								particular database making it impossible
	*								to delete that database.
	*/
	public function connect($use_db = true)
	{
		parent::connect($use_db);

		// See whether this fixes the travis issue
		$this->get_pdo()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	}

	/**
	* Load the phpBB database schema into the database
	*/
	public function load_schema()
	{
		$this->ensure_connected(__METHOD__);

		$directory = __DIR__ . '/../../blog/develop/schemas/';
		$this->load_schema_from_file($directory);

		// Also load the phpBB schema's
		parent::load_schema();
	}
}
