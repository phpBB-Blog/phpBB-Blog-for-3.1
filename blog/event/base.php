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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener base class
 */
abstract class phpbb_ext_phpbbblog_event_base implements EventSubscriberInterface
{
	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $phpEx;

	/** @var phpbb_template */
	protected $template;

	/** @var phpbb_user */
	protected $user;

	public function __construct()
	{
		global $phpbb_root_path, $phpEx;
		global $phpbb_container;

		$this->phpbb_root_path	= $phpbb_root_path;
		$this->phpEx			= $phpEx;

		$this->template	= $phpbb_container->get('template');
		$this->user		= $phpbb_container->get('user');
	}

	/** @var bool */
	static private $is_blog = null;

	/**
	 * Only register event listeners when the user is
	 * actually visiting the blog.
	 */
	static public function getBlogSubscribedEvents(array $events)
	{
		if (is_null(self::$is_blog))
		{
			global $request;
			self::$is_blog = strpos($request->variable('controller', ''), 'blog') === 0;
		}

		return (self::$is_blog) ? $events : array();
	}
}
