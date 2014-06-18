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
	*/
	public function __construct(\phpbb\request\request $request, \phpbb_blog\blog\display $display, \phpbb\config\config $config, \phpbb_blog\blog\operators\posts $posts, \phpbb_blog\blog\operators\tags $tags, \phpbb_blog\blog\operators\categories $categories, \phpbb_blog\blog\operators\comments $comments, \phpbb\template\template $template)
	{
		$this->request = $request;
		$this->display = $display;

		// TODO: Re-order all the params to be in alphabetical order
		$this->config = $config;
		$this->posts = $posts;
		$this->tags = $tags;
		$this->categories = $categories;
		$this->comments = $comments;
		$this->template = $template;
	}

	/**
	 * Frontpage Controller
	 */
	public function main()
	{
		// Load Posts: load comments, number of posts, order
		$posts = $this->posts->getPosts(false, $this->config['blog_frontpage_posts'], 'desc');
		// Get tags: Should we show unused tags? Most number of posts in cat first
		$tags = $this->tags->getTagsArray($this->config['blog_show_unused_tags'], 'size');
		// Get Categoires: Should we show unused categories?  Most number of posts in cat first
		$categories = $this->categories->getCategoryArray($this->config['blog_show_unused_cats'], 'size');

		// Output blog entries to template
		$this->assign_block_posts($posts);

		// Output tags to template
		foreach ($tags as $tag)
		{
			$this->template->assign_block_vars('tag', array(
				'ID' 	=> $tag['id'],
				'LINK'	=> $tag['link'],
				'NAME'	=> $tag['title'],
			));
		}

		// Output categories to template
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

		// Parse bbcodes used in blog posting
		$blogMessage = generate_text_for_display(
			$postdata['message_text'],
			$postData['message_uid'],
			$postData['message_bitfield'],
			$postData['message_options']
		);

		// Output blog post data
		$this->template->assign_vars(array(
			'BLOG_ID'					=> $postData['blog_id'],
			'BLOG_MESSAGE' 				=> $blogMessage,
			'BLOG_POSTER'				=> $postData['poster_name'],
			'BLOG_POSTER_LINK'			=> $postData['poster_link'],
			'BLOG_POSTER_COLOUR'		=> $postData['poster_colour'],
			'BLOG_TITLE'				=> $postData['blog_title'],
			'COMMENT_COUNT'				=> $postData['comment_count'],
			'BLOG_LAST_EDIT_TIME'		=> $postData['last_edit_time'],
			'BLOG_EDIT_NUMBER'			=> $postData['edit_number'],
			'BLOG_LAST_EDITOR'			=> $postData['last_editor'],
			'BLOG_LAST_EDITOR_COLOUR'	=> $postData['last_editor_colour'],
		));

		foreach ($comments as $comment)
		{
			// Parse comment bbcode
			$commentMessage = generate_text_for_display(
				$comment['message_text'],
				$comment['message_uid'],
				$comment['message_bitfield'],
				$comment['message_options']
			);

			// Output comment data
			$this->template->assign_block_vars('comment', array(
				'ID' 			=> $comment['id'],
				'CONTENT'		=> $commentMessage,
				'TITLE'			=> $comment['title'],
				'CONTENT'		=> $comment['content'],
				'COMMENT_COUNT'	=> $comment['comment_count'],
				'POSTER_NAME'	=> $comment['poster_name'],
				'POSTER_COLOUR' => $comment['poster_colour'],
				'POSTER_LINK'	=> $comment['poster_link'],
				'STATUS'		=> $comment['status'],
			));
		}

		// Todo: Add links template variables
		return $this->display->render('post_view');
	}

	private function assign_block_posts($posts)
	{
		foreach ($posts as $post)
		{
			$blogMessage = generate_text_for_display(
				$postdata['message_text'],
				$postData['message_uid'],
				$postData['message_bitfield'],
				$postData['message_options']
			);

			// TODO refactor this so this function outputs the array below and
			// the assign_block_vars magic is done elsewhere so this can be
			// used for getting individual posts too
			$this->template->assign_block_vars('post', array(
				'ID' 	=> $post['id'],
				'LINK'	=> $post['link'],
				'TITLE'	=> $post['title'],
				'CONTENT'	=> $blogMessage,
				'COMMENT_COUNT'	=> $post['comment_count'],
				'POSTER_NAME'	=> $post['poster_name'],
				'POSTER_COLOUR' => $post['poster_colour'],
				'POSTER_LINK'	=> $post['poster_link'],
				'CATEGORY'		=> $post['category'], // TODO: Make this plural later
			));
		}
	}
}
