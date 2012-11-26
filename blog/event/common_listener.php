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
 * core.common listener
 *
 * The listener class that is called from the `core.common`
 * event.
 */
class phpbb_ext_phpbbblog_event_common_listener extends phpbb_ext_phpbbblog_event_base
{
	static public function getSubscribedEvents()
	{
		return parent::getBlogSubscribedEvents(array(
			'core.common' => 'common',
		));
	}

	public function common($event)
	{
		// Include some files that can't be autoloaded
		require __DIR__ . "/../includes/constants.{$this->phpEx}";

		// Include the common language file
		$this->user->add_lang_ext('phpbbblog', 'blog');
	}
}
