<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\controller;

class core
{
	protected $request;
	protected $display;

	/**
	* Constructor
	*
	* @param \phpbb\request\request 		$request  	Request Object
	* @param \phpbb_blog\blog\display 	$display 	Display Helper Object
	*/
	public function __construct(\phpbb\request\request $request, \phpbb_blog\blog\display $display)
	{
		$this->request = $request;
		$this->display = $display;
	}

	public function main()
	{
		return $this->display->render('blog_main');
	}

	public function categoryPostsView($category)
	{
		return $this->display->render('blog_category_view');
	}

	public function tagPostsView($tag)
	{
		return $this->display->render('blog_tag_view');
	}

	public function postView($identifier)
	{
		return $this->display->render('blog_post_view');
	}
}
