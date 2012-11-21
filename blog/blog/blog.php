<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
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
	/** @var ContainerBuilder */
	private $phpbb_container;

	/** @var dbal */
	private $db;

	/** @var phpbb_request */
	private $request;

	/**
	 * @param ContainerBuilder $phpbb_container
	 * @param phpbb_request $request
	 * @param dbal $db
	 */
	public function __construct(ContainerBuilder $phpbb_container, phpbb_request $request, dbal $db)
	{
		$this->phpbb_container	= $phpbb_container;
		$this->db				= $db;
		$this->request			= $request;
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
		$categories = $this->container->get('blog.model.categories');
		$categories->load();

		// Send the responce
		$response = '<h1>Categories:</h1>';
		foreach ($categories as $category)
		{
			$response .= "Category: {$category->get_id()}, data: <pre> {$category}</pre><hr />";
		}

		return new Response($response, 200);
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
		$categories = $this->container->get('blog.model.categories');
		$categories->load($cat);

		// Get the posts
		$posts = $categories->get_category($cat)->get_posts();

		$response = '<h1>Posts:</h1>';
		
	}
}
