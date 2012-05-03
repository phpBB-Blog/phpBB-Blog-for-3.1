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
class phpbb_ext_blog_blog_objects_comments extends phpbb_ext_blog_blog_objects_base
{
	protected $comment = '';
	protected $commenter_id = 0;
	protected $options = 0;
	protected $bitfield = '';
	protected $uid = '';
	protected $ctime = 0;

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
}
