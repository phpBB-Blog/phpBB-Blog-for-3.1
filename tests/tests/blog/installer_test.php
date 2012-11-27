<?php
/**
 *
 * @package phpBBBlog-tests
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class installer_test extends blog_database_test_case
{
	private $db;
	private $installer;

	protected function setUp()
	{
		global $cache, $db, $phpbb_root_path;
		$db		= $this->new_dbal();
		$cache	= new phpbb_mock_cache();

		// Installer gets setup with a different table prefix, to assure
		// that it is properly changed.
		$this->installer = new phpbb_ext_phpbbblog_blog_installer($db, $phpbb_root_path, '.php', 'blog_test_');
	}

	protected function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/installer_fixture.xml');
	}

	public function test_install_tables()
	{
		$db = $this->new_dbal();

		// Install it
		$this->installer->install_tables();

		// Try to insert the rows from the fixture in the newly created table
		$sql = 'SELECT *
			FROM phpbb_blog_categories';
		$result	= $db->sql_query_limit($sql, 1);
		$row	= $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$sql = 'INSERT INTO blog_test_blog_categories ' . $db->sql_build_array('INSERT', $row);
		$db->sql_query($sql);

		$this->assertSame(1, $db->sql_affectedrows());
	}

	public function test_install_permissions()
	{
		$db = $this->new_dbal();

		// Control
		$sql = 'SELECT auth_option_id
			FROM ' . ACL_OPTIONS_TABLE . "
			WHERE auth_option = 'a_blog'";
		$result	= $db->sql_query($sql);
		$aui	= $db->sql_fetchfield('auth_option_id', false, $result);
		$db->sql_freeresult($result);
		$this->assertFalse($aui);

		$this->installer->install_permissions();

		$sql = 'SELECT auth_option
			FROM ' . ACL_OPTIONS_TABLE . "
			WHERE auth_option = 'a_blog'";
		$result	= $db->sql_query($sql);
		$option	= $db->sql_fetchfield('auth_option', false, $result);
		$db->sql_freeresult($result);
		$this->assertSame('a_blog', $option);
	}

	public function test_install_modules()
	{
		$db = $this->new_dbal();

		// Control
		$sql = 'SELECT module_id
			FROM ' . MODULES_TABLE . "
			WHERE module_langname = 'ACP_BLOG_CATEGORIES_OVERVIEW'";
		$result	= $db->sql_query($sql);
		$aui	= $db->sql_fetchfield('module_id', false, $result);
		$db->sql_freeresult($result);
		$this->assertFalse($aui);

		$this->installer->install_modules();

		$expected = array(
			'module_enabled'	=> '1',
			'module_display'	=> '1',
			'module_basename'	=> 'phpbb_ext_phpbbblog_acp_categories_module',
			'module_class'		=> 'acp',
			'module_langname'	=> 'ACP_BLOG_CATEGORIES_OVERVIEW',
			'module_mode'		=> 'overview',
			'module_auth'		=> 'acl_a_blog',	
		);

		$sql = 'SELECT module_enabled, module_display, module_basename, module_class, module_langname, module_mode, module_auth
			FROM ' . MODULES_TABLE . "
			WHERE module_langname = 'ACP_BLOG_CATEGORIES_OVERVIEW'";
		$result	= $db->sql_query($sql);
		$row	= $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertSame($expected, $row);
	}

	public function test_disable_modules()
	{
		$db = $this->new_dbal();
		$this->installer->install_modules();

		$sql = 'SELECT module_enabled
			FROM ' . MODULES_TABLE . "
			WHERE module_langname = 'ACP_BLOG_CATEGORIES_MANAGEMENT'";
		$result	= $db->sql_query($sql);
		$enable	= $db->sql_fetchfield('module_enabled', false, $result);
		$db->sql_freeresult($result);

		$this->assertSame(1, (int) $enable);

		// Disable
		$this->installer->disable_modules();

		$sql = 'SELECT module_enabled
			FROM ' . MODULES_TABLE . "
			WHERE module_langname = 'ACP_BLOG_CATEGORIES_MANAGEMENT'";
		$result	= $db->sql_query($sql);
		$enable	= $db->sql_fetchfield('module_enabled', false, $result);
		$db->sql_freeresult($result);

		$this->assertSame(0, (int) $enable);
	}
}
