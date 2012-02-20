<?php

abstract class blog_database_test_case extends phpbb_database_test_case
{
	public function get_database_config()
	{
		$config = array();

		if (!defined(dbms))
		{
			$config = array_merge($config, array(
				'dbms'		=> 'sqlite',
				'dbhost'	=> dirname(__FILE__) . '/../blog_unit_tests.sqlite2', // filename
				'dbport'	=> '',
				'dbname'	=> '',
				'dbuser'	=> '',
				'dbpasswd'	=> '',
			));
		}
		else
		{
			$config = array_merge($config, array(
				'dbms'		=> dbms,
				'dbhost'	=> dbhost,
				'dbport'	=> dbport,
				'dbname'	=> dbname,
				'dbuser'	=> dbuser,
				'dbpasswd'	=> dbpasswd,
			));
		}

		if (!isset($config['dbms']))
		{
			$this->markTestSkipped('Missing test_config.php: See first error.');
		}

		return $config;
	}

	protected function create_connection_manager($config)
	{
		return new blog_database_test_connection_manager($config);
	}
}
