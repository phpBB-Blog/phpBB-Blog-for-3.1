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
 * core.common listener
 *
 * The listener class that is called from the `core.common`
 * event.
 */
class common_listener extends base
{
	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return parent::getBlogSubscribedEvents(array(
			'core.common' => 'common',
		));
	}

	/**
	 * @param Event $event
	 */
	public function common($event)
	{
		// Include some files that can't be autoloaded
		require __DIR__ . "/../includes/constants.{$this->php_ext}";

		// Include the common language file
		$this->user->add_lang_ext('phpbbblog', 'blog');
	}
}
