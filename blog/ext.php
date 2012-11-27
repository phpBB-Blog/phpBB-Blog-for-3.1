<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Extend the phpBB extension base
 */
class phpbb_ext_phpbbblog_ext implements phpbb_extension_interface
{
	/** @var string */
	private $php_ext;

	/** @var string */
	private $root_path;

	/** @var array */
	private $schema_data;

	/** @var ContainerBuilder */
	private $container;

	public function __construct()
	{
		global $phpbb_container;

		$this->container 	= $phpbb_container;
		$this->php_ext		= ".{$phpbb_container->getParameter('core.php_ext')}";
		$this->root_path	= $phpbb_container->getParameter('core.root_path');
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable_step($old_state)
	{
		$step_state = array(
			'tables'		=> false,
			'permissions'	=> false,
			'modules'		=> false,
		);

		if (is_array($old_state))
		{
			$step_state = array_merge($step_state, $old_state);
		}

		// Install the tables
		if ($step_state['tables'] !== true)
		{
			if (!class_exists('db_tools'))
			{
				require "{$this->root_path}includes/db/db_tools{$this->php_ext}";
			}
			$db_tools = new phpbb_db_tools($this->container->get('dbal.conn'));

			$this->init_schema_data();
			$db_tools->perform_schema_changes(array('add_tables' => $this->schema_data));

			$step_state['tables'] = true;
		}
		else if ($step_state['permissions'] !== true)
		{
			if (!class_exists('auth_admin'))
			{
				require "{$this->root_path}includes/acp/auth{$this->php_ext}";
			}
			$auth_admin = new auth_admin();

			$permissions = array(
				'local'		=> array(
				),
				'global'	=> array(
					// Blog admin permissions
					'a_blog',
				),
			);

			$auth_admin->acl_add_option($permissions);

			$step_state['permissions'] = true;
		}
		else if ($step_state['modules'] !== true)
		{
			$db = $this->container->get('dbal.conn');

			if (!class_exists('acp_modules'))
			{
				include "{$this->root_path}includes/acp/acp_modules{$this->php_ext}";
			}
			$module_admin = new acp_modules();
			$module_admin->module_class = 'acp';

			// Array holding the class names of the "info" classes
			$modules = array(
				'phpbb_ext_phpbbblog_acp_categories_info' => 'phpbb_ext_phpbbblog_acp_categories_module',
			);

			// Get the id of `.MODs`
			$sql = 'SELECT module_id
				FROM ' . MODULES_TABLE . "
				WHERE module_langname = 'ACP_CAT_DOT_MODS'";
			$result	= $db->sql_query($sql);
			$pid	= $db->sql_fetchfield('module_id', false, $result);
			$db->sql_freeresult($result);

			// Add the blog categories "module category"
			$module_category = array(
				'module_basename'	=> '',
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				'parent_id'			=> $pid,
				'module_class'		=> 'acp',
				'module_langname'	=> 'ACP_BLOG_CATEGORIES_MANAGEMENT',
				'module_mode'		=> '',
				'module_auth'		=> 'acl_a_blog',
			);

			$sql = 'SELECT module_id
				FROM ' . MODULES_TABLE . "
				WHERE module_langname = 'ACP_BLOG_CATEGORIES_MANAGEMENT'";
			$result	= $db->sql_query($sql);
			$mid	= $db->sql_fetchfield('module_id', false, $result);
			$db->sql_freeresult($result);

			if ($mid)
			{
				$module_category['module_id'] = $mid;
			}

			$module_admin->update_module_data($module_category, true);

			// Add the modules/modes
			foreach ($modules as $info_class => $module_class)
			{
				$info = new $info_class();
				$data = $info->module();

				foreach ($data['modes'] as $mode => $mode_data)
				{
					$module = array(
						'module_basename'	=> $module_class,
						'module_enabled'	=> 1,
						'module_display'	=> 1,
						'parent_id'			=> $module_category['module_id'],
						'module_class'		=> 'acp',
						'module_langname'	=> $mode_data['title'],
						'module_mode'		=> $mode,
						'module_auth'		=> $mode_data['auth'],
					);

					$sql = 'SELECT module_id
						FROM ' . MODULES_TABLE . "
						WHERE module_langname = '{$mode_data['title']}'";
					$result	= $db->sql_query($sql);
					$mid	= $db->sql_fetchfield('module_id', false, $result);
					$db->sql_freeresult($result);

					if ($mid)
					{
						$module['module_id'] = $mid;
					}

					$module_admin->update_module_data($module, false);
					unset($module, $mid);
				}
			}

			$step_state['modules'] = true;
		}
		else
		{
			return false;
		}

		return $step_state;
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable_step($old_state)
	{
		$db = $this->container->get('dbal.conn');

		// Disable the acp module
		if (!class_exists('acp_modules'))
		{
			include "{$this->root_path}includes/acp/acp_modules{$this->php_ext}";
		}
		$module_admin = new acp_modules();
		$module_admin->module_class = 'acp';

		$sql = 'SELECT *
			FROM ' . MODULES_TABLE . "
			WHERE module_langname = 'ACP_BLOG_CATEGORIES_MANAGEMENT'";
		$result	= $db->sql_query($sql);
		$cat	= $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$cat['module_enabled'] = 0;
		$module_admin->update_module_data($cat, true);

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function purge_step($old_state)
	{
		return false;
	}

	/**
	 * Set the schema data
	 */
	private function init_schema_data()
	{
		if (empty($this->schema_data))
		{
			$data = array(
				'phpbb_blog_categories'	=> array(
					'COLUMNS'		=> array(
						'id'			=> array('UINT', NULL, 'auto_increment'),
						'name'			=> array('STEXT_UNI', '', 'true_sort'),
						'description'	=> array('MTEXT_UNI', ''),
						'options'		=> array('UINT:11', 7),
						'bitfield'		=> array('VCHAR:255', ''),
						'uid'			=> array('VCHAR:8', ''),
						'total_posts'	=> array('UINT', 0),
						'last_post_id'	=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'id',
				),
				'phpbb_blog_posts'		=> array(
					'COLUMNS'		=> array(
						'id'			=> array('UINT', NULL, 'auto_increment'),
						'category'		=> array('UINT', 0),
						'title'			=> array('STEXT_UNI', '', 'true_sort'),
						'poster_id'		=> array('UINT', 0),
						'post'			=> array('TEXT_UNI', ''),
						'options'		=> array('UINT:11', 7),
						'bitfield'		=> array('VCHAR:255', ''),
						'uid'			=> array('VCHAR:8', ''),
						'post_time'		=> array('TIMESTAMP', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> array(
						'category'		=> array('INDEX', 'category'),
					),
				),
			);

			// Correct table prefix
			$prefix = $this->container->getParameter('core.table_prefix');
			if ($prefix != 'phpbb_')
			{
				$tables = array_keys($data);
				foreach ($tables as $table)
				{
					$data[str_replace('phpbb_', $prefix, $table)] = $data[$table];
					unset($data[$table]);
				}
			}

			$this->schema_data = $data;
		}
	}
}
