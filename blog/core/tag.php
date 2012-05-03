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
class phpbb_ext_blog_blog_core_tag
{
	private $db;
	private $id = 0;
	private $tag = '';
	private $tag_count = 0;

	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->setID($id);

		if ($this->id > 0)
		{
			$this->loadTag();
		}
	}

	public function loadTag()
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
			$this->tag			= $tag['tag'];
			$this->tag_count	= $tag['tag_count'];
		}
	}

	public function setID($id)
	{
		$this->id = (int) $id;
	}

	public function getTag()
	{
		return $this->tag;
	}
}
