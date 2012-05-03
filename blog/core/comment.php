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
class phpbb_ext_blog_blog_core_comment
{
	private $db;
	private $id = 0;
	private $comment = '';
	private $commenter_id = 0;
	private $options = 0;
	private $bitfield = '';
	private $uid = '';
	private $ctime = 0;

	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->set_id($id);

		if ($this->id > 0)
		{
			$this->load();
		}
	}

	public function load()
	{
		$sql_ary = array(
			'SELECT'	=> 'pc.comment,
							pc.commenter_id,
							pc.options,
							pc.bitfield,
							pc.uid,
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

		if (!empty($result))
		{
			$this->set_data($comment);
		}
	}

	public function set_data(array $data)
	{
		$this->comment		= $data['comment'];
		$this->commenter_id	= $data['commenter_id'];
		$this->options		= $data['options'];
		$this->bitfield		= $data['bitfield'];
		$this->uid			= $data['uid'];
		$this->ctime		= $data['ctime'];
	}

	public function parse()
	{
		return $this->comment;
	}

	public function set_id($id)
	{
		$this->id = (int) $id;
	}
}
