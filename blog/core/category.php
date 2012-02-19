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
class phpbb_ext_blog_core_category
{
	private $db;
	private $id;
	private $title;
	private $description;
	private $description_options;
	private $description_bitfield;
	private $description_uid;
	private $total_posts;
	private $last_post_id;

	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->setID($id);

		if ($this->id > 0)
		{
			$this->loadCategory();
		}
	}

	public function loadCategory()
	{
		$sql_ary = array(
			'SELECT'	=> 'bc.title,
							bc.description,
							bc.description_options,
							bc.description_bitfield,
							bc.description_uid,
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

		$this->title				= $category['title'];
		$this->description			= $category['description'];
		$this->description_options	= $category['description_options'];
		$this->description_bitfield	= $category['description_bitfield'];
		$this->description_uid		= $category['description_uid'];
		$this->total_posts			= $category['total_posts'];
		$this->last_post_id			= $category['last_post_id'];
	}

	public function setID($id)
	{
		$this->id = (int) $id;
	}

	public function getTitle()
	{
		return $this->title;
	}
}
