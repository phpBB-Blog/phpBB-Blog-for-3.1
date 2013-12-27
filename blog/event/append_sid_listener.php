<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
 * core.common listener
 *
 * The listener class that is called from the `core.common`
 * event.
 */
class append_sid_listener extends base
{
	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return parent::getBlogSubscribedEvents(array(
			'core.append_sid' => 'append_sid',
		));
	}

	/**
	 * @param Event $event
	 */
	public function append_sid($event)
	{
		// Build the correct URL
		if ($event['url'] == 'blog')
		{
			$event['url'] = "{$this->root_path}app.{$this->php_ext}";

			// Make sure that `params` is an array
			if (empty($event['params']))
			{
				$event['params'] = array();
			}


			$event['params'] = array_merge($event['params'], array(
				'controller' => 'blog',
			));
		}
	}
}
