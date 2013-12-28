<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\blog;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Installer service provider
 */
class display
{
	/** @var \phpbb\controller\helper */
	private $helper;

	/** @var \phpbb\template */
	private $template;

	/** @var \phpbb\user */
	private $user;

	public function __construct(\phpbb\controller\helper $helper, \phpbb\template $template, \phpbb\user $user)
	{
		$this->helper	= $helper;
		$this->template	= $template;
		$this->user		= $user;
	}

	public function render($html_file)
	{
		// Build the navlinks
		$this->gen_nav_links();

		$html_file = rtrim($html_file, '.html') . '.html';
		return $this->helper->render($html_file);
	}

	private function gen_nav_links()
	{
		// The "blog" home link
		$this->template->assign_block_vars('navlinks', array(
			'S_IS_CAT'		=> true,
			'S_IS_LINK'		=> false,
			'S_IS_POST'		=> false,
			'FORUM_NAME'	=> $this->user->lang('BLOG_MAIN'),
			'FORUM_ID'		=> -1,
			'U_VIEW_FORUM'	=> append_sid('blog'),
		));
	}
}
