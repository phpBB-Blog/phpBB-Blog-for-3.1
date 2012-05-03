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
class phpbb_ext_blog_blog_core_category
{
	private $db;
	private $id = 0;
	private $title = '';
	private $description = '';
	private $options = 0;
	private $bitfield = '';
	private $uid = '';
	private $total_posts = 0;
	private $last_post_id = 0;

	private $posts = array();

	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->set_id($id);

		if ($this->id > 0)
		{
			$this->load_category();
			$this->get_posts();
		}
	}

	public function load_category()
	{
		$sql_ary = array(
			'SELECT'	=> 'bc.title,
							bc.description,
							bc.options,
							bc.bitfield,
							bc.uid,
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

		if (!empty($category))
		{
			$this->title		= $category['title'];
			$this->description	= $category['description'];
			$this->options		= $category['options'];
			$this->bitfield		= $category['bitfield'];
			$this->uid			= $category['uid'];
			$this->total_posts	= $category['total_posts'];
			$this->last_post_id	= $category['last_post_id'];
		}
	}

	public function load_posts()
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
							p.read_count,
							p.last_edit_time,
							p.edit_count,
							p.comment_count,
							p.comment_lock',
			'FROM'		=> array(
				BLOG_POSTS_TABLE	=> 'p',
			),
			'WHERE'		=> 'p.category = ' . $this->id,
		);

		$sql		= $this->db->sql_build_query('SELECT', $sql_ary);
		$result		= $this->db->sql_query($sql);
		$posts		= $this->db->sql_fetchrowset($result);

		if (!empty($posts))
		{
			foreach ($posts as $p)
			{
				$post = new phpbb_ext_blog_blog_core_post($this->db);
				$post->set_id($p['id']);
				$post->set_data($p);
				$this->posts[] = $post;
			}
		}

		$this->db->sql_freeresult($result);
	}

	public function get_posts()
	{
		if ($this->total_posts > 0)
		{
			$this->load_posts();
		}

		return $this->posts;
	}

	public function set_id($id)
	{
		$this->id = (int) $id;
	}

	public function get_title()
	{
		return $this->title;
	}
}
