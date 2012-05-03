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
 * Represents a blog post, is resposible for parsing/storing/editing/etc
 * of a blog post
 */
class phpbb_ext_blog_blog_objects_post extends phpbb_ext_blog_blog_objects_base
{
	/**
	 * Array containing all comment objects linked to this blog post
	 * @var array
	 */
	protected $comments = array();

	protected $category = 0;
	protected $title = '';
	protected $post = '';
	protected $poster_id = 0;
	protected $options = 0;
	protected $bitfield = '';
	protected $uid = '';
	protected $ptime = 0;
	protected $read_count = 0;
	protected $last_edit_time = 0;
	protected $edit_count = 0;
	protected $comment_count = 0;
	protected $comment_lock = 0;

	/**
	 * Get the post data
	 *
	 * Fetch all information related to this blog post from the database
	 * and fill the class properties accordingly.
	 *
	 * @return void
	 */
	public function load()
	{
		$sql_ary = array(
			'SELECT'	=> 'bp.id,
							bp.category,
							bp.title,
							bp.poster_id,
							bp.post,
							bp.options,
							bp.bitfield,
							bp.uid,
							bp.ptime,
							bp.read_count,
							bp.last_edit_time,
							bp.edit_count,
							bp.comment_count,
							bp.comment_lock',
			'FROM'		=> array(
				BLOG_POSTS_TABLE => 'bp',
			),
			'WHERE'		=> 'bp.id = ' . $this->id,
		);

		$sql	= $this->db->sql_build_query('SELECT', $sql_ary);
		$result	= $this->db->sql_query($sql);
		$post	= $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!empty($post))
		{
			$this->set_data($post);
			$this->load_comments();
		}
		else
		{
			// Blog doesn't exist, so re-set the ID to `0`
			$this->id = 0;
		}
	}

	/**
	 * Submit blog post
	 *
	 * This method takes the current blog information as hold by
	 * the post object and submits it into the database. If no
	 * post ID is set, a new blog post will be created. Otherwise
	 * the blogpost will be updated.
	 */
	public function submit()
	{
		// @todo add some validation/sanitisation


		// Prepare the data
		$data = array(
			'category'			=> $this->category,
			'title'				=> $this->title,
			'poster_id'			=> $this->poster_id,
			'post'				=> $this->post,
			'options'			=> $this->options,
			'bitfield'			=> $this->bitfield,
			'uid'				=> $this->uid,
			'ptime'				=> $this->ptime,
			'read_count'		=> $this->read_count,
			'last_edit_time'	=> $this->last_edit_time,
			'edit_count'		=> $this->edit_count,
			'comment_count'		=> $this->comment_count,
			'comment_lock'		=> $this->comment_lock,
		);

		if (!$this->id)
		{
			$mode	= 'INSERT';
			$sql	= 'INSERT INTO ' . BLOG_POSTS_TABLE . '%s';
		}
		else
		{
			// Set post ID
			$data['id'] = $this->id;

			$mode = 'UPDATE';
			$sql	= 'UPDATE ' . BLOG_POSTS_TABLE . '
					SET %s
					WHERE id = ' . $this->id;
		}

		$sql = sprintf($sql, $this->db->sql_build_array($mode, $data));
		$this->db->sql_query($sql);

		// Set the new ID
		$this->id = $this->db->sql_nextid();
	}

	/**
	 * Initialise post comments
	 *
	 * Fetch all the comments that are made to the selected
	 * blog post
	 *
	 * @return void
	 */
	private function load_comments()
	{
		$sql_ary = array(
			'SELECT'	=> 'pc.id,
							pc.comment,
							pc.commenter_id,
							pc.options,
							pc.bitfield,
							pc.uid,
							pc.ctime',
			'FROM'		=> array(
				BLOG_POST_COMMENTS_TABLE => 'pc',
			),
			'WHERE'		=> 'pc.post_id = ' . $this->id,
			'ORDER_BY'	=> 'pc.ctime DESC',
		);

		$sql		= $this->db->sql_build_query('SELECT', $sql_ary);
		$result		= $this->db->sql_query($sql);
		$comments	= $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		if (!empty($comments))
		{
			foreach ($comments as $c)
			{
				$comment = new phpbb_ext_blog_blog_objects_comments($this->db);
				$comment->set_data($c);
				$this->comments[] = $comment;
			}
		}
	}

	/**
	 * Get post comments
	 *
	 * Get all the posts comments
	 */
	public function get_comments()
	{
		// Only if needed
		if (empty($this->comments) && $this->comment_count > 0)
		{
			$this->load_comments();
		}

		return $this->comments;
	}
}
