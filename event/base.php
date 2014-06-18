<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Event listener base class
 */
abstract class base implements EventSubscriberInterface
{
	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var ContainerBuilder */
	protected $phpbb_container;

	/** @var phpbb_template */
	protected $template;

	/** @var phpbb_user */
	protected $user;

	public function __construct()
	{
		global $phpbb_container;

		$this->root_path		= $phpbb_container->getParameter('core.root_path');
		$this->php_ext			= $phpbb_container->getParameter('core.php_ext');

		$this->template			= $phpbb_container->get('template');
		$this->user				= $phpbb_container->get('user');

		$this->phpbb_container	= $phpbb_container;
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
