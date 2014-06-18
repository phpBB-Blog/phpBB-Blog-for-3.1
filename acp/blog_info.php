<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb_blog\blog\acp;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @package module_install
 */
class blog_info
{
	public function module()
	{
		return array(
			'title'		=> 'ACP_BLOG_MANAGEMENT',
			'filename'	=> '\phpbb_blog\blog\acp\blog_module',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'overview'	=> array(
					'title'	=> 'ACP_BLOG_MANAGEMENT',
					'auth'	=> 'acl_a_blog',
					'cat'	=> array(
						'ACP_BLOG_MANAGEMENT',
					),
				),
			),
		);
	}
}
