<?php

abstract class blog_database_test_case extends phpbb_database_test_case
{
	protected function create_connection_manager($config)
	{
		return new blog_database_test_connection_manager($config);
	}
}
