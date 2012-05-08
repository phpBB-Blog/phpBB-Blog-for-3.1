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
 * Represents a blog tag, is resposible for parsing/storing/editing/etc
 * of a tag
 */
class phpbb_ext_blog_blog_objects_tag extends phpbb_ext_blog_blog_objects_base
{
	protected $tag = '';
	protected $tag_count = 0;

	public function load()
	{
		$sql_ary = array(
			'SELECT'	=> 't.tag,
							t.tag_count',
			'FROM'		=> array(
				BLOG_TAGS_TABLE => 't',
			),
			'WHERE'		=> 't.id = ' . $this->id,
		);

		$sql	= $this->db->sql_build_query('SELECT', $sql_ary);
		$result	= $this->db->sql_query($sql);
		$tag	= $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!empty($tag))
		{
			$this->set_data($tag);
		}
	}
}
