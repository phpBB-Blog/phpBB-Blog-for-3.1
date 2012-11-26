<?php

abstract class blog_database_test_case extends phpbb_database_test_case
{
	protected function setUp()
	{
		parent::setUp();

		// Setup the cache object, some tests require this object to be
		// available in the global scope
		global $cache;

		$_driver	= new phpbb_cache_driver_file(__DIR__ . '/tmp');
		$cache		= new phpbb_cache_service($_driver);
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
