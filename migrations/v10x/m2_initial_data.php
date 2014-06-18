<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb_blog\blog\migrations\v10x;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Initial data changes needed for Extension installation
 */
class m2_initial_data extends \phpbb\db\migration\migration
{
	/**
	 * @inheritdoc
	 */
	static public function depends_on()
	{
		return array('\phpbb_blog\blog\migrations\v10x\m1_initial_schema');
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_BLOG_MANAGEMENT')),
			array('module.add', array('acp', 'ACP_BLOG_MANAGEMENT', array(
					'module_basename'	=> '\phpbb_blog\blog\acp\blog_module',
					'modes'				=> array('overview'),
			))),
		);
	}

	/**
	 * @inheritdoc
	 */
	public function revert_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BLOG_MANAGEMENT',
			)),
		);
	}
}
