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
 * Installer service provider
 */
class phpbb_ext_phpbbblog_blog_display
{
	/** @var phpbb_controller_helper */
	private $helper;

	/** @var phpbb_template */
	private $template;

	/** @var phpbb_user */
	private $user;

	public function __construct(phpbb_controller_helper $helper, phpbb_template $template, phpbb_user $user)
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
