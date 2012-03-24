<?php
/**
 *
 * @package phpBB-Blog
 * @copyright (c) 2012 phpBB-Blog
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * Post object
 *
 * Represents a blog category, is resposible for parsing/storing/editing/etc
 * of a category
 */
class phpbb_ext_blog_core_category
{
	private $db;
	private $id;
	private $title;
	private $description;
	private $description_options;
	private $description_bitfield;
	private $description_uid;
	private $total_posts;
	private $last_post_id;

	private $posts = array();

	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->setID($id);

		if ($this->id > 0)
		{
			$this->loadCategory()->getPosts();
		}
	}

	public function loadCategory()
	{
		$sql_ary = array(
			'SELECT'	=> 'bc.title,
							bc.description,
							bc.description_options,
							bc.description_bitfield,
							bc.description_uid,
							bc.total_posts,
							bc.last_post_id',
			'FROM'		=> array(
				BLOG_CATEGORIES_TABLE => 'bc',
			),
			'WHERE'		=> 'bc.id = ' . $this->id,
		);

		$sql		= $this->db->sql_build_query('SELECT', $sql_ary);
		$result		= $this->db->sql_query($sql);
		$category	= $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->title				= $category['title'];
		$this->description			= $category['description'];
		$this->description_options	= $category['description_options'];
		$this->description_bitfield	= $category['description_bitfield'];
		$this->description_uid		= $category['description_uid'];
		$this->total_posts			= $category['total_posts'];
		$this->last_post_id			= $category['last_post_id'];

		return $this;
	}

	public function loadPosts()
	{
		$sql_ary = array(
			'SELECT'	=> 'p.id,
							p.title,
							p.poster_id,
							p.post,
							p.options,
							p.bitfield,
							p.uid
							p.ptime,
							p.post_read_count,
							p.post_last_edit_time,
							p.post_edit_count,
							p.post_comment_count,
							p.post_comment_lock',
			'FROM'		=> array(
				BLOG_POSTS_TABLE	=> 'p',
			),
			'WHERE'		=> 'p.category = ' . $this->id,
		);

		$sql		= $this->db->sql_build_query('SELECT', $sql_ary);
		$result		= $this->db->sql_query($sql);
		$posts		= $this->db->sql_fetchrowset($result);

		foreach ($posts as $p)
		{
			$post = new phpbb_ext_blog_core_post($this->db);
			$post->setPostID($p['id']);
			$post->setPostData($p);
			$this->posts[] = $post;
		}

		$this->db->sql_freeresult($result);
	}

	public function getPosts()
	{
		if ($this->totalPosts > 0)
		{
			$this->loadPosts();
		}

		return $this->posts;
	}

	public function setID($id)
	{
		$this->id = (int) $id;
	}

	public function getTitle()
	{
		return $this->title;
	}
}
