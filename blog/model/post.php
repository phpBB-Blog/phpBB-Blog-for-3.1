<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\model;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Post model
 */
class post
{
	/**
	 * @var \phpbb\db\driver\driver
	 */
	protected $db;

	/**
	 * @var string
	 */
	protected $blog_posts_table;

	/**
	 * @var string
	 */
	protected $blog_comments_table;

	/**
	 * @var string
	 */
	protected $blog_categories_table;

	/**
	 * @var string
	 */
	protected $blog_post_tags_table;

	/**
	 * @var string
	 */
	protected $blog_post_categories_table;

	/**
	 * Construct method
	 *
	 * @param \phpbb\db\driver\driver $db
	 * @param string $blog_posts_table
	 * @param string $blog_comments_table
	 * @param string $blog_categories_table
	 * @param string $blog_post_tags_table
	 * @param string $blog_post_categories_table
	 */
	public function __construct(\phpbb\db\driver\driver $db, $blog_posts_table, $blog_comments_table, $blog_categories_table, $blog_post_tags_table, $blog_post_categories_table)
	{
		$this->db = $db;
		$this->blog_posts_table = $blog_posts_table;
		$this->blog_comments_table = $blog_comments_table;
		$this->blog_categories_table = $blog_categories_table;
		$this->blog_post_categories_table = $this->blog_post_categories_table;
		$this->blog_post_tags_table = $this->blog_post_tags_table;
	}

	/**
	 * Create a post using the given information
	 *
	 * @param string $title
	 * @param string $slug
	 * @param int $time
	 * @param bool $status
	 * @param bool $Locked
	 * @param int $poster_id
	 * @param string $content
	 * @param string $bbcode_uid
	 * @param string $bbcode_bitfield
	 * @param array $categories Array of category IDs
	 * @param array $tags Array of tag IDs
	 * @return bool
	 */
	public function create($title, $slug, $time, $status, $locked, $poster_id, $content, $bbcode_uid, $bbcode_bitfield, array $categories, array $tags)
	{
		$sql = 'INSERT INTO ' . $this->blog_posts_table . ' ' . $this->db->sql_build_array('INSERT', array(
			'title' => $title,
			'slug' => $slug,
			'time' => (int) $time,
			'status' => (bool) $status,
			'locked' => (bool) $locked,
			'poster_id' => (int) $poster_id,
			'content' => $content,
			'bbcode_uid' => $bbcode_uid,
			'bbcode_bitfield' => $bbcode_bitfield,
		));
		$this->db->sql_query($sql);
		$post_id = (int) $this->db->sql_next_id();

		foreach ($categories as $category_id)
		{
			$sql = 'INSERT INTO ' . $this->blog_post_categories_table . ' ' . $this->db->sql_build_array('INSERT', array(
				'post_id' => (int) $post_id,
				'category_id' => (int) $category_id,
			));
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . $this->blog_categories_table . ' SET post_count = post_count + 1 WHERE id = ' . (int) $category_id;
			$this->db->sql_query($sql);
		}

		foreach ($tags as $tag_id)
		{
			$sql = 'INSERT INTO ' . $this->blog_post_tags_table . ' ' . $this->db->sql_build_array('INSERT', array(
				'post_id' => (int) $post_id,
				'tag_id' => (int) $tag_id,
			));
			$this->db->sql_query($sql);
		}

		return true;
	}

	/**
	 * Update a blog post using the given information
	 *
	 * @param int $id
	 * @param string $title
	 * @param string $slug
	 * @param int $time
	 * @param int $edit_time
	 * @param string $edit_reason
	 * @param bool $status
	 * @param bool $locked
	 * @param int $poster_id
	 * @param int $comment_count
	 * @param string $content
	 * @param string $bbcode_uid
	 * @param string $bbcode_bitfield
	 * @param array $categories Array of category IDs
	 * @param array $tags Array of tag IDs
	 * @return bool
	 */
	public function update($id, $title, $slug, $time, $edit_time, $edit_reason, $status, $locked, $poster_id, $comment_count, $content, $bbcode_uid, $bbcode_bitfield, array $categories, array $tags)
	{
		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET ' . $this->db->sql_build_array('UPDATE', array(
			'title' => $title,
			'slug' => $slug,
			'time' => (int) $time,
			'edit_time' => (int) $edit_time,
			'edit_reason' => $edit_reason,
			'status' => (bool) $status,
			'locked' => (bool) $locked,
			'poster_id' => (int) $poster_id,
			'comment_count' => (int) $comment_count,
			'content' => $content,
			'bbcode_uid' => $bbcode_uid,
			'bbcode_bitfield' => $bbcode_bitfield,
		)) . ' WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		// Handle category changes
		$sql = 'SELECT category_id FROM ' . $this->blog_post_categories_table . ' WHERE post_id = ' . (int) $id;
		$result = $this->db->sql_query($sql);

		$current_categories = array();
		while($row = $this->db->sql_fetchrow($result))
		{
			$current_categories[] = $row['category_id'];
		}
		$this->db->sql_freeresult($result);

		$added_categories = array_diff($categories, $current_categories);
		$removed_categories = array_diff($current_categories, $categories);

		foreach ($added_categories as $added_category)
		{
			$sql = 'INSERT INTO ' . $this->blog_post_categories_table . ' ' . $this->db->sql_build_array('INSERT', array(
				'post_id' => (int) $post_id,
				'category_id' => (int) $added_category,
			));
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . $this->blog_categories_table . ' SET post_count = post_count + 1 WHERE id = ' . (int) $category_id;
			$this->db->sql_query($sql);
		}

		foreach ($removed_categories as $removed_category)
		{
			$sql = 'DELETE FROM ' . $this->blog_post_categories_table . '
				WHERE post_id = ' . (int) $id . '
					AND category_id = ' . (int) $removed_category;
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . $this->blog_categories_table . ' SET post_count = post_count - 1 WHERE id = ' . (int) $category_id;
			$this->db->sql_query($sql);
		}

		// Handle tag changes
		$sql = 'SELECT tag_id FROM ' . $this->blog_post_tags_table . ' WHERE post_id = ' . (int) $id;
		$result = $this->db->sql_query($sql);

		$current_tags = array();
		while($row = $this->db->sql_fetchrow($result))
		{
			$current_tags[] = $row['tag_id'];
		}
		$this->db->sql_freeresult($result);

		$added_tags = array_diff($tags, $current_tags);
		$removed_categories = array_diff($current_tags, $tags);

		foreach ($added_tags as $added_tag)
		{
			$sql = 'INSERT INTO ' . $this->blog_post_tags_table . ' ' . $this->db->sql_build_array('INSERT', array(
				'post_id' => (int) $post_id,
				'category_id' => (int) $added_tag,
			));
		}

		foreach ($removed_tags as $removed_tag)
		{
			$sql = 'DELETE FROM ' . $this->blog_post_tags_table . '
				WHERE post_id = ' . (int) $id . '
					AND category_id = ' . (int) $removed_tag;
			$this->db->sql_query($sql);
		}

		return true;
	}

	/**
	 * Delete
	 *
	 * @param int $id
	 * @return bool
	 */
	protected function delete($id)
	{
		$sql = 'SELECT category_id FROM ' . $this->blog_post_table . 'WHERE id = ' . (int) $id;
		$result = $this->db->sql_query($sql);
		$category_id = $this->db->sql_fetchfield('category_id');
		$this->db->sql_freeresult($result);

		if (!$category_id)
		{
			return false;
		}

		$sql = 'DELETE FROM ' . $this->blog_posts_table . ' WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		$sql = 'DELETE FROM ' . $this->blog_comments_table . ' WHERE post_id = ' . (int) $id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->blog_categories_table . ' SET post_count = post_count - 1 WHERE id = ' . (int) $category_id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Lock a post
	 *
	 * @param int $id
	 * @return bool
	 */
	public function lock($id)
	{
		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET locked = 1 WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Unlock a post
	 *
	 * @param int $id
	 * @return bool
	 */
	public function unlock($id)
	{
		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET locked = 0 WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Approve a post
	 *
	 * @param int $id
	 * @return bool
	 */
	public function approve($id)
	{
		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET status = 1 WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Disapprove a post
	 *
	 * @param int $id
	 * @return bool
	 */
	public function disapprove($id)
	{
		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET status = 0 WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		return true;
	}
}
