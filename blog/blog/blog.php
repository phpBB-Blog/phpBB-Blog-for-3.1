<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;

class phpbb_ext_phpbbblog_blog
{
	private $db;
	private $request;

	public function __construct(ContainerBuilder $container, phpbb_request $request, dbal $db)
	{
		$this->container	= $container;
		$this->db			= $db;
		$this->request		= $request;
	}

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
