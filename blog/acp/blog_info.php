<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
