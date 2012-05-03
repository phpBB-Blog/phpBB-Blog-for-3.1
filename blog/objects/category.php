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
class phpbb_ext_blog_blog_objects_category extends phpbb_ext_blog_blog_objects_base
{
	protected $title = '';
	protected $description = '';
	protected $options = 0;
	protected $bitfield = '';
	protected $uid = '';
	protected $total_posts = 0;
	protected $last_post_id = 0;

	protected $posts = array();

	public function load()
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
			$this->set_data($category);
			$this->load_posts();
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
				$post = new phpbb_ext_blog_blog_objects_post($this->db);
				$post->set_data($p);
				$this->posts[] = $post;
			}
		}

		$this->db->sql_freeresult($result);
	}

	public function get_posts()
	{
		if (empty($this->posts) && $this->total_posts > 0)
		{
			$this->load_posts();
		}

		return $this->posts;
	}
}
