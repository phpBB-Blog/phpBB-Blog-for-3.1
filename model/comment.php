<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
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
	 * Construct method
	 *
	 * @param \phpbb\db\driver\driver $db
	 * @param string $blog_comments_table
	 * @param string $block_posts_table
	 */
	public function __construct(\phpbb\db\driver\driver $db, $blog_comments_table, $blog_posts_table)
	{
		$this->db = $db;
		$this->blog_comments_table = $blog_comments_table;
		$this->blog_posts_table = $blog_posts_table;
	}

	/**
	 * Create a comment using the given information
	 *
	 * @param int $post_id
	 * @param int $time
	 * @param bool $status
	 * @param int $poster_id
	 * @param string $content
	 * @param string $bbcode_uid
	 * @param string $bbcode_bitfield
	 * @return bool
	 */
	public function create($post_id, $time, $status, $poster_id, $content, $bbcode_uid, $bbcode_bitfield)
	{
		$sql = 'INSERT INTO ' . $this->blog_comments_table . ' ' . $this->db->sql_build_array('INSERT', array(
			'post_id' => (int) $post_id,
			'time' => (int) $time,
			'status' => (bool) $status,
			'poster_id' => (int) $poster_id,
			'content' => $content,
			'bbcode_uid' => $bbcode_uid,
			'bbcode_bitfield' => $bbcode_bitfield,
		));
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET comment_count = comment_count + 1 WHERE id = ' . (int) $post_id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Update a blog post using the given information
	 *
	 * @param int $id
	 * @param int $post_id
	 * @param int $time
	 * @param int $edit_time
	 * @param string $edit_reason
	 * @param bool $status
	 * @param int $poster_id
	 * @param int $comment_count
	 * @param string $content
	 * @param string $bbcode_uid
	 * @param string $bbcode_bitfield
	 * @return bool
	 */
	public function update($id, $title, $slug, $time, $edit_time, $edit_reason, $status, $locked, $poster_id, $comment_count, $content, $bbcode_uid, $bbcode_bitfield)
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

		return true;
	}

	/**
	 * Delete a comment
	 *
	 * @param int $id
	 * @return bool
	 */
	public function delete($id)
	{
		$sql = 'SELECT post_id FROM ' . $this->blog_comments_table . 'WHERE id = ' . (int) $id;
		$result = $this->db->sql_query($sql);
		$post_id = $this->db->sql_fetchfield('post_id');
		$this->db->sql_freeresult($result);

		if (!$post_id)
		{
			return false;
		}

		$sql = 'DELETE FROM ' . $this->blog_comments_table . ' WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->blog_posts_table . ' SET comment_count = comment_count - 1 WHERE id = ' . (int) $post_id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Approve a comment
	 *
	 * @param int $id
	 * @return bool
	 */
	public function approve($id)
	{
		$sql = 'UPDATE ' . $this->blog_comments_table . ' SET status = 1 WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		return true;
	}

	/**
	 * Disapprove a comment
	 *
	 * @param int $id
	 * @return bool
	 */
	public function disapprove($id)
	{
		$sql = 'UPDATE ' . $this->blog_comments_table . ' SET status = 0 WHERE id = ' . (int) $id;
		$this->db->sql_query($sql);

		return true;
	}
}
