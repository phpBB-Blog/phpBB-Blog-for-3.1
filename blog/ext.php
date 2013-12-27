<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog;

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
class ext implements \phpbb\extension\base
{
	/** @var phpbb_blog\blog\blog_installer */
	private $installer;

	/** @var ServiceContainer */
	private $container;

	public function __construct()
	{
		global $phpbb_container;

		$this->installer = new phpbb_blog\blog\blog\installer(
			$phpbb_container->get('dbal.conn'),
			$phpbb_container->getParameter('core.root_path'),
			".{$phpbb_container->getParameter('core.php_ext')}",
			$phpbb_container->getParameter('core.table_prefix')
		);
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
			$this->installer->install_tables();
			$step_state['tables'] = true;
		}
		else if ($step_state['permissions'] !== true)
		{
			$this->installer->install_permissions();
			$step_state['permissions'] = true;
		}
		else if ($step_state['modules'] !== true)
		{
			$this->installer->install_modules();
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
		$this->installer->disable_modules();

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function purge_step($old_state)
	{
		return false;
	}
}
