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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main blog class
 *
 * All requests are handled through this class
 */
class phpbb_ext_phpbbblog_blog
{
	/** @var dbal */
	private $db;

	/** phpbb_controller_helper */
	private $helper;

	/** @var phpbb_template */
	private $template;

	/** @var phpbb_request */
	private $request;

	/** @var phpbb_ext_phpbbblog_model_bag_categories */
	private $categories;

	/**
	 * @param ContainerBuilder $phpbb_container
	 * @param dbal $db
	 * @param phpbb_request $request
	 * @param template $template
	 */
	public function __construct(phpbb_controller_helper $helper, dbal $db, phpbb_request $request, phpbb_template $template, phpbb_ext_phpbbblog_model_bag_categories $categories)
	{
		$this->db			= $db;
		$this->helper		= $helper;
		$this->request		= $request;
		$this->template		= $template;

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
		return $this->helper->render('blog_main.html');
	}

	/**
	 * Category view
	 *
	 * This method is called when the users visits
	 * a specific category
	 *
	 * @return Response
	 */
	public function category($cat)
	{
		// Get the category
		$this->categories->load($cat);

		// Get the posts
		$posts = $categories->get_category($cat)->get_posts();

		$response = '<h1>Posts:</h1>';
		
	}
}
