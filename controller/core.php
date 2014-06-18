<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/
namespace phpbb_blog\blog\controller;

class core
{
	protected $request;
	protected $display;

	protected $config;
	protected $posts;
	protected $tags;
	protected $categories;
	protected $comments;
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\request\request 		$request  	Request Object
	* @param \phpbb_blog\blog\display 	$display 	Display Helper Object
	*/
	public function __construct(\phpbb\request\request $request, \phpbb_blog\blog\display $display, \phpbb\config\config $config, \phpbb_blog\blog\operators\posts $posts, \phpbb_blog\blog\operators\tags $tags, \phpbb_blog\blog\operators\categories $categories, \phpbb_blog\blog\operators\comments $comments, \phpbb\template\template $template)
	{
		$this->request = $request;
		$this->display = $display;

		$this->config = $config;
		$this->posts = $posts;
		$this->tags = $tags;
		$this->categories = $categories;
		$this->comments = $comments;
		$this->template = $template;
	}

	public function main()
	{
		// load comments, number of posts, order
		$posts = $this->posts->getPosts(false, $this->config['blog_frontpage_posts'], 'desc');
		// Most number of posts first
		$tags = $this->tags->getTagsArray($this->config['blog_show_unused_tags'], 'size');
		$categories = $this->categories->getCategoryArray($this->config['blog_show_unused_cats'], 'size');

		$this->assign_block_posts($posts);

		foreach ($tags as $tag)
		{
			$this->template->assign_block_vars('tag', array(
				'ID' 	=> $tag['id'],
				'LINK'	=> $tag['link'],
				'NAME'	=> $tag['title'],
			));
		}

		foreach ($categories as $cat)
		{
			$this->template->assign_block_vars('cat', array(
				'ID' 	=> $cat['id'],
				'LINK'	=> $cat['link'],
				'NAME'	=> $cat['title'],
			));
		}

		return $this->display->render('main');
	}

	public function categoryPostsView($category)
	{
		$categories = $this->categories->getCategorySimpleList();
		if (!in_array($category, $categories))
		{
			trigger_error('This is not a valid category'); // TODO: Turn this into a language variable.
		}

		$posts = $this->posts->getPosts(false, $this->config['blog_frontpage_posts'], 'desc',  $category);
		$this->assign_block_posts($posts);

		$this->template->assign_vars(array(
			'CATEGORY' => $category,
		));

		return $this->display->render('category_view');
	}

	public function tagPostsView($tag)
	{
		$tags = $this->tags->getTagSimpleList();
		if (!in_array($tag, $tags))
		{
			trigger_error('This is not a valid tag'); // TODO: Use language vars
		}

		$posts = $this->posts->getPosts(false, $this->config['blog_frontpage_posts'], 'desc',  null, $tag);
		$this->assign_block_posts($posts);

		$this->template->assign_vars(array(
			'TAG' => $tag,
		));

		return $this->display->render('tag_view');
	}

	public function postView($identifier)
	{
		if (is_int($identifier))
		{
			$postData = $this->posts->getPostId($identifier);
		}
		else
		{
			$postData = $this->posts->getPost($identifier);
		}

		$comments = $this->comments->getCommentsByPost($postData['id']);

		// TODO: Output post & comment data to template

		return $this->display->render('post_view');
	}

	private function assign_block_posts($posts)
	{
		foreach ($posts as $post)
		{
			$this->template->assign_block_vars('post', array(
				'ID' 	=> $post['id'],
				'LINK'	=> $post['link'],
				'TITLE'	=> $post['title'],
				'CONTENT'	=> $post['content'],
				'COMMENT_COUNT'	=> $post['comment_count'],
				'POSTER_NAME'	=> $post['poster_name'],
				'POSTER_LINK'	=> $post['name'],
				'CATEGORY'		=> $post['category'], // TODO: Make this plural later
			));
		}
	}
}
