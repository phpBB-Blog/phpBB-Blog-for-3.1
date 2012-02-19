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
class phpbb_ext_blog_core_post
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
	private $bbcode_options = 0;
	private $bbcode_bitfield = '';
	private $ptime = 0;
	private $post_read_count = 0;
	private $post_last_edit_time = 0;
	private $post_edit_count = 0;
	private $post_comment_count = 0;
	private $post_comment_lock = 0;

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
		$this->setPostID($id);

		// Fetch the blog data if needed
		if ($this->id > 0)
		{
			$this->loadPost();
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
	public function loadPost()
	{
		$sql_ary = array(
			'SELECT'	=> 'bp.id,
							bp.category,
							bp.title,
							bp.post,
							bp.poster_id,
							bp.bbcode_options,
							bp.bbcode_bitfield,
							bp.bbcode_uid,
							bp.ptime,
							bp.post_read_count,
							bp.post_last_edit_time,
							bp.post_edit_count,
							bp.post_comment_count,
							bp.post_comment_lock',
			'FROM'		=> array(
				BLOG_POSTS_TABLE => 'bp',
			),
			'WHERE'		=> 'bp.id = ' . $this->id,
		);

		$sql	= $this->db->sql_build_query('SELECT', $sql_ary);
		$result	= $this->db->sql_query($sql);
		$post	= $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->category				= $post['category'];
		$this->title				= $post['title'];
		$this->post					= $post['post'];
		$this->poster_id			= $post['poster_id'];
		$this->bbcode_options		= $post['bbcode_options'];
		$this->bbcode_bitfield		= $post['bbcode_bitfield'];
		$this->ptime				= $post['ptime'];
		$this->post_read_count		= $post['post_read_count'];
		$this->post_last_edit_time	= $post['post_last_edit_time'];
		$this->post_edit_count		= $post['post_edit_count'];
		$this->post_comment_count	= $post['post_comment_count'];
		$this->post_comment_lock	= $post['post_comment_lock'];
	}

	/**
	 * Initialise post comments
	 *
	 * Fetch all the comments that are made to the selected
	 * blog post
	 *
	 * @return void
	 */
	private function fetchComments()
	{
		$sql_ary = array(
			'SELECT'	=> 'pc.id,
							pc.comment,
							pc.commenter_id,
							pc.comment_options,
							pc.comment_bitfield,
							pc.comment_uid,
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

		foreach ($comments as $c)
		{
			$comment = new phpbb_ext_blog_core_comment($this->db);
			$comment->setCommentID($c['id']);
			$comment->setCommentData($c);
			$this->comments[] = $comment;
		}
	}

	/**
	 * Get post comments
	 *
	 * Get all the posts comments
	 */
	public function getComments()
	{
		// Only if needed
		if ($this->post_comment_count > 0)
		{
			$this->fetchComments();
		}

		return $this->comments;
	}

	/**
	 * Set the blog post ID
	 */
	public function setPostID($id)
	{
		$this->id = (int) $id;
	}

	public function getTitle()
	{
		return $this->title;
	}
}
