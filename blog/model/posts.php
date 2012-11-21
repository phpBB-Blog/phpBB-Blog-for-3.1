<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Posts container
 *
 * Class that holds all the posts that are
 * available in a category
 */
class phpbb_ext_phpbbblog_model_posts extends phpbb_ext_phpbbblog_model_container_base
{
	/**
	 * Load posts
	 *
	 * Load the posts, by default all
	 * posts are fetched, but it is also posible
	 * to load only specific categories.
	 *
	 * @param int|array $ids Specific posts to load
	 */
	public function load($ids = array())
	{
		$rowset = $this->loadContainer();

		foreach ($rowset as $row)
		{
			$this[] = new phpbb_ext_phpbbblog_model_post(array_shift($row), $row, $this->db);
		}
	}
}
