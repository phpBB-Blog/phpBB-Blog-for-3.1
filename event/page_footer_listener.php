<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/
namespace phpbb_blog\blog\event;

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
class page_footer_listener extends base
{
	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return parent::getBlogSubscribedEvents(array(
			'core.page_footer' => 'page_footer',
		));
	}

	/**
	 * @param Event $event
	 */
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
