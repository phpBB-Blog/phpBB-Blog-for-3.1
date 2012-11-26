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
 * core.page_footer listener
 *
 * The listener class that is called from the `core.page_footer`
 * event.
 */
class phpbb_ext_phpbbblog_event_page_footer_listener extends phpbb_ext_phpbbblog_event_base
{
	static public function getSubscribedEvents()
	{
		return parent::getBlogSubscribedEvents(array(
			'core.page_footer' => 'page_footer',
		));
	}

	public function page_footer($event)
	{
		// Finish the blog copyright line and inject it into the
		// phpBB "POWERED_BY" line so it gets properly displayed
		$this->user->lang['POWERED_BY'] .= '<br />' . $this->user->lang(
											'BLOG_COPYRIGHT',
											'<a href="https://github.com/phpBB-Blog/" title="phpBB-Blog">phpBB-Blog</a>'
		);
	}
}
