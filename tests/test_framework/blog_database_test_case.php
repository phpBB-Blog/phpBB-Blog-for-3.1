<?php

abstract class blog_database_test_case extends phpbb_database_test_case
{
	protected function setUp()
	{
		parent::setUp();

		// Setup the cache object, some tests require this object to be
		// available in the global scope
		global $cache;
		$cache = new phpbb_mock_cache();

		// Set a global dbal object
		global $db;
		$db = $this->new_dbal();
	}

	protected function create_connection_manager($config)
	{
		return new blog_database_test_connection_manager($config);
	}

	public function get_test_case_helpers()
	{
		if (!$this->test_case_helpers)
		{
			$this->test_case_helpers = new blog_test_case_helpers($this);
		}

		return $this->test_case_helpers;
	}
}
