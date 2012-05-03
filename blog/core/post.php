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
class phpbb_ext_blog_blog_core_post
{
	/**
	 * The phpBB DB object
	 * @var DBAL
	 */
	private $db;

	/**
	 * ID of the represented blog post
	 * @var integer
	 */
	private $id;

	/**
	 * Array containing all comment objects linked to this blog post
	 * @var array
	 */
	private $comments = array();

	private $category = 0;
	private $title = '';
	private $post = '';
	private $poster_id = 0;
	private $options = 0;
	private $bitfield = '';
	private $uid = '';
	private $ptime = 0;
	private $read_count = 0;
	private $last_edit_time = 0;
	private $edit_count = 0;
	private $comment_count = 0;
	private $comment_lock = 0;

	/**
	 * Initialise the object
	 *
	 * @param dbal    $db The phpBB database object
	 * @param integer $id The blog ID. If set > 0 the object represents an existing
	 *                    post that will be fetched from the database. Otherwise
	 *                    this is a "new" entry.
	 */
	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->set_id($id);

		// Fetch the blog data if needed
		if ($this->id > 0)
		{
			$this->load();
			$this->get_comments();
		}
	}

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
		}
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
				$comment = new phpbb_ext_blog_blog_core_comment($this->db);
				$comment->set_id($c['id']);
				$comment->set_data($c);
				$this->comments[] = $comment;
			}
		}
	}

	public function set_data(array $data)
	{
		$this->post				= $data['post'];
		$this->category			= $data['category'];
		$this->title			= $data['title'];
		$this->poster_id		= $data['poster_id'];
		$this->options			= $data['options'];
		$this->bitfield			= $data['bitfield'];
		$this->uid				= $data['uid'];
		$this->ptime			= $data['ptime'];
		$this->read_count		= $data['read_count'];
		$this->last_edit_time	= $data['last_edit_time'];
		$this->edit_count		= $data['edit_count'];
		$this->comment_count	= $data['comment_count'];
		$this->comment_lock		= $data['comment_lock'];
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

	/**
	 * Set the blog post ID
	 */
	public function set_id($id)
	{
		$this->id = (int) $id;
	}

	public function get_title()
	{
		return $this->title;
	}
}
