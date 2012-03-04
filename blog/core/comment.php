<?php
/**
 *
 * @package phpBB-Blog
 * @copyright (c) 2012 phpBB-Blog
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * Comment object
 *
 * Represents a blog post comment, is resposible for parsing/storing/editing/etc
 * of a blog post
 */
class phpbb_ext_blog_core_comment
{
	private $db;
	private $id;
	private $comment;
	private $commenter_id;
	private $comment_options;
	private $comment_bitfield;
	private $comment_uid;
	private $ctime;

	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->setCommentID($id);

		if ($this->id > 0)
		{
			$this->loadComment();
		}
	}

	public function loadComment()
	{
		$sql_ary = array(
			'SELECT'	=> 'pc.comment,
							pc.commenter_id,
							pc.comment_options,
							pc.comment_bitfield,
							pc.comment_uid,
							pc.ctime',
			'FROM'		=> array(
				BLOG_POST_COMMENTS_TABLE => 'pc',
			),
			'WHERE'		=> 'pc.id = ' . $this->id,
		);

		$sql		= $this->db->sql_build_query('SELECT', $sql_ary);
		$result		= $this->db->sql_query($sql);
		$comment	= $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (empty($result))
		{
			return;
		}

		$this->setCommentData($comment);
	}

	public function setCommentData(array $data)
	{
		$this->comment			= $data['comment'];
		$this->commenter_id		= $data['commenter_id'];
		$this->comment_options	= $data['comment_options'];
		$this->comment_bitfield	= $data['comment_bitfield'];
		$this->comment_uid		= $data['comment_uid'];
		$this->ctime			= $data['ctime'];
	}

	public function parseComment()
	{
		return $this->comment;
	}

	public function setCommentID($id)
	{
		$this->id = (int) $id;
	}
}
