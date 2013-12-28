<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main blog class
 *
 * All requests are handled through this class
 */
class blog
{
	/** @var \phpbb\db\driver\driver */
	private $db;

	/** @var \phpbb_blog\blog\display */
	private $display;

	/** @var \phpbb\request\request */
	private $request;

	/** @var \phpbb_blog\blog\model\bag\categories */
	private $categories;

	/**
	 * Constructor method
	 *
	 * @param \phpbb\db\driver\driver $db
	 * @param \phpbb\request\request $request
	 * @param \phpbb_blog\blog\blog\display $display
	 * @param \phpbb_blog\blog\model\bag\categories $categories
	 */
	public function __construct(\phpbb\db\driver\driver $db, \phpbb\request\request $request, \phpbb_blog\blog\blog\display $display, \phpbb_blog\blog\model\bag\categories $categories)
	{
		$this->db			= $db;
		$this->display		= $display;
		$this->request		= $request;
		$this->categories	= $categories;
	}

	/**
	 * Main route
	 *
	 * This method is called when the user visits the blog
	 * homepage.
	 *
	 * @return Response
	 */
	public function main()
	{
		// Fetch the categories
		$this->categories->load();

		// Send the page out
		return $this->display->render('blog_main');
	}

	/**
	 * Category view
	 *
	 * This method is called when the users visits
	 * a specific category
	 *
	 * @return Response
	 */
	public function category($category)
	{
		// Get the category
		$this->categories->load($category);

		// Get the posts
		$posts = $this->categories->get_category($category)->get_posts();

		$response = '<h1>Posts:</h1>';

	}
}
